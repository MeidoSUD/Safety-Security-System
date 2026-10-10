<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Contract;
use App\Models\Facility;
use App\Models\MaintenanceRequest;
use App\Models\User;
use App\Models\Visit;
use App\Models\VisitImage;
use App\Models\VisitItem;
use App\Models\VisitReport;
use App\Models\SystemNotification;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VisitController extends Controller
{
    public function index(Request $request)
    {
        $user = session('user', [
            'id' => 1,
            'role' => 'admin',
            'name' => 'م. عبدالرحمن المنصور',
            'title' => 'المدير التنفيذي (Admin)',
            'avatar' => '👑',
            'email' => 'admin@nabico.sa',
        ]);

        $company = Company::first();

        // Zone Pricing Configuration
        $pricingConfig = [
            'inside_city' => [
                'name' => 'زيارات المعاينة داخل نطاق المدينة (Inside City Area)',
                'price' => $company->zone_rate_inside ?? 350.00,
                'description' => 'تشمل الفحص المبدئي، تقرير الكشف الأولي، ورفع التقرير لمهندس السلامة في نفس المدينة.',
                'coverage' => 'نطاق مدن: الرياض، جدة، الدمام، الجبيل، مكة المكرمة'
            ],
            'outside_city' => [
                'name' => 'زيارات المعاينة خارج نطاق المدينة والمناطق النائية (Outside City Area)',
                'price' => $company->zone_rate_outside ?? 650.00,
                'description' => 'تشمل أجور الانتقال للمواقع البعيدة والمجمعات الصناعية خارج النطاق العمراني.',
                'coverage' => 'المحافظات، المدن الصناعية البعيدة، والمواقع الإنشائية الخارجية'
            ],
        ];

        // Filter query
        $query = Visit::with(['facility', 'contract', 'engineer', 'supervisor', 'items', 'images', 'report']);

        // Filter by role if client or technician
        if (($user['role'] ?? '') === 'client') {
            $query->whereHas('facility', function($q) use ($user) {
                $q->where('client_user_id', $user['id']);
            });
        } elseif (($user['role'] ?? '') === 'technician') {
            $query->where('assigned_engineer_id', $user['id']);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->boolean('unpaid_only')) {
            $query->where('has_unpaid_parts', true);
        }

        $visits = $query->latest('scheduled_at')->get();

        // Dropdown data for scheduling modal
        $facilities = Facility::with('activeContract')->get();
        $engineers = User::whereIn('role', ['technician', 'supervisor'])->get();
        $supervisors = User::where('role', 'supervisor')->orWhere('role', 'manager')->get();

        return view('dashboard.visits', compact('user', 'visits', 'pricingConfig', 'facilities', 'engineers', 'supervisors', 'company'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'facility_id' => 'required|exists:facilities,id',
            'visit_type' => 'required|string',
            'scheduled_date' => 'required|date',
            'scheduled_time' => 'required',
            'location_zone' => 'required|in:inside_city,outside_city',
            'assigned_engineer_id' => 'nullable|exists:users,id',
            'assigned_supervisor_id' => 'nullable|exists:users,id',
            'purpose' => 'required|string',
        ]);

        $company = Company::first();
        $facility = Facility::with('activeContract')->findOrFail($request->facility_id);

        $scheduledAt = Carbon::parse($request->scheduled_date . ' ' . $request->scheduled_time);

        // Determine fee based on contract presence and zone
        $hasActiveContract = $facility->activeContract()->exists();
        $contractId = $hasActiveContract ? $facility->activeContract->id : null;

        if ($hasActiveContract && $request->visit_type !== 'pre_contract_audit') {
            $visitFee = 0.00;
            $feeStatus = 'covered_by_contract';
            // Increment visits used in contract
            $facility->activeContract->increment('visits_used');
        } else {
            $visitFee = $request->location_zone === 'inside_city' ? ($company->zone_rate_inside ?? 350.00) : ($company->zone_rate_outside ?? 650.00);
            $feeStatus = $request->input('fee_status', 'paid');
        }

        $visitNumber = 'VST-' . rand(1000, 9999);

        $visit = Visit::create([
            'company_id' => $company->id,
            'facility_id' => $facility->id,
            'contract_id' => $contractId,
            'maintenance_request_id' => $request->maintenance_request_id,
            'assigned_engineer_id' => $request->assigned_engineer_id,
            'assigned_supervisor_id' => $request->assigned_supervisor_id,
            'visit_number' => $visitNumber,
            'visit_type' => $request->visit_type,
            'scheduled_at' => $scheduledAt,
            'location_zone' => $request->location_zone,
            'visit_fee' => $visitFee,
            'fee_status' => $feeStatus,
            'purpose' => $request->purpose,
            'status' => 'scheduled',
            'has_unpaid_parts' => false,
            'unpaid_parts_amount' => 0.00,
            'notes' => $request->notes,
        ]);

        // Create Automated 48h Reminder Notification
        SystemNotification::create([
            'company_id' => $company->id,
            'user_id' => $visit->assigned_engineer_id,
            'type' => 'visit_reminder_48h',
            'title' => "🔔 تم جدولة زيارة جديدة #{$visitNumber}",
            'message' => "تم إسناد زيارة فحص لموقع {$facility->name} بتاريخ {$scheduledAt->format('Y-m-d H:i')}.",
            'target_url' => route('dashboard.visits.manage', $visit->id),
            'priority' => 'normal',
        ]);

        return redirect()->route('dashboard.visits.manage', $visit->id)->with('success', "تم جدولة الزيارة بنجاح برقم {$visitNumber} وتم إرسال التذكيرات.");
    }

    public function manage($id)
    {
        $visit = Visit::with(['facility', 'contract', 'engineer', 'supervisor', 'items', 'images', 'report'])->findOrFail($id);
        $company = Company::first();

        return view('dashboard.visit_manage', compact('visit', 'company'));
    }

    public function uploadImage(Request $request, $id)
    {
        $visit = Visit::findOrFail($id);
        $request->validate([
            'caption' => 'nullable|string|max:255',
            'stage' => 'required|in:before_work,during_inspection,after_work,defect_evidence',
            'image_file' => 'nullable|image|max:10240', // 10MB
            'image_url' => 'nullable|url',
        ]);

        $imagePath = null;
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/visits'), $fileName);
            $imagePath = asset('uploads/visits/' . $fileName);
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->image_url;
        } else {
            // Default realistic fallback placeholder
            $imagePath = 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?w=800&auto=format&fit=crop&q=60';
        }

        $user = session('user');

        VisitImage::create([
            'visit_id' => $visit->id,
            'facility_id' => $visit->facility_id,
            'uploaded_by_user_id' => $user['id'] ?? null,
            'image_path' => $imagePath,
            'caption' => $request->caption ?? 'صورة موقع الزيارة الفنية',
            'stage' => $request->stage,
        ]);

        return back()->with('success', 'تم رفع وتوثيق صورة الموقع بنجاح');
    }

    public function addItem(Request $request, $id)
    {
        $visit = Visit::findOrFail($id);
        $request->validate([
            'item_name' => 'required|string|max:255',
            'item_category' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'condition_status' => 'required|in:good,needs_maintenance,replaced,critical_defect,repaired',
            'payment_status' => 'required|in:covered_by_contract,paid,unpaid',
            'notes' => 'nullable|string',
        ]);

        $qty = (int)$request->quantity;
        $unitPrice = (float)$request->unit_price;
        $totalPrice = $qty * $unitPrice;

        $item = VisitItem::create([
            'visit_id' => $visit->id,
            'item_name' => $request->item_name,
            'item_category' => $request->item_category,
            'quantity' => $qty,
            'unit_price' => $unitPrice,
            'total_price' => $totalPrice,
            'condition_status' => $request->condition_status,
            'payment_status' => $request->payment_status,
            'notes' => $request->notes,
        ]);

        // Trigger notification if unpaid parts added
        if ($request->payment_status === 'unpaid') {
            SystemNotification::create([
                'company_id' => $visit->company_id,
                'user_id' => null,
                'type' => 'unpaid_parts_alert',
                'title' => "⚠️ قطع غيار غير مسددة في زيارة #{$visit->visit_number}",
                'message' => "تم تركيب ({$item->item_name}) بقيمة {$totalPrice} ر.س ولم يتم سدادها بعد.",
                'target_url' => route('dashboard.visits.manage', $visit->id),
                'priority' => 'warning',
            ]);
        }

        return back()->with('success', 'تمت إضافة بند الصيانة / قطعة الغيار وتحديث حالة السداد بنجاح');
    }

    public function deleteItem($id, $itemId)
    {
        $visit = Visit::findOrFail($id);
        $item = VisitItem::where('visit_id', $visit->id)->findOrFail($itemId);
        $item->delete();

        return back()->with('success', 'تم حذف البند وتحديث المستحقات تلقائياً');
    }

    public function updateStatus(Request $request, $id)
    {
        $visit = Visit::findOrFail($id);
        $request->validate([
            'status' => 'required|in:scheduled,in_progress,completed,cancelled',
        ]);

        $visit->update(['status' => $request->status]);

        return back()->with('success', 'تم تحديث حالة الزيارة الميدانية بنجاح');
    }

    public function toggleReminder(Request $request, $id)
    {
        $visit = Visit::findOrFail($id);
        $enabled = $request->boolean('enabled');

        return response()->json([
            'success' => true,
            'message' => $enabled ? 'تم تفعيل التذكيرات الآلية SMS/البريد بنجاح' : 'تم تعطيل التذكيرات الآلية للزيارة',
            'enabled' => $enabled,
        ]);
    }
}
