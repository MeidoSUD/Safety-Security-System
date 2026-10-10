<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Facility;
use App\Models\MaintenanceRequest;
use App\Models\User;
use App\Models\Visit;
use App\Models\SystemNotification;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MaintenanceRequestController extends Controller
{
    public function index()
    {
        $user = session('user');
        $company = Company::first();

        $query = MaintenanceRequest::with(['facility', 'requester', 'visit']);

        if (($user['role'] ?? '') === 'client') {
            $query->whereHas('facility', function($q) use ($user) {
                $q->where('client_user_id', $user['id']);
            });
        }

        $requests = $query->latest()->get();
        $facilities = Facility::all();
        $engineers = User::whereIn('role', ['technician', 'supervisor'])->get();

        return view('dashboard.maintenance_requests', compact('requests', 'facilities', 'engineers', 'company', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'facility_id' => 'required|exists:facilities,id',
            'type' => 'required|in:emergency,preventive,inspection,quote_request',
            'priority' => 'required|in:low,medium,high,critical',
            'system_type' => 'required|string',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'preferred_date' => 'nullable|date',
            'site_photo_url' => 'nullable|url',
        ]);

        $company = Company::first();
        $user = session('user');

        $photos = [];
        if ($request->hasFile('site_photo_file')) {
            $file = $request->file('site_photo_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/requests'), $fileName);
            $photos[] = asset('uploads/requests/' . $fileName);
        } elseif ($request->filled('site_photo_url')) {
            $photos[] = $request->site_photo_url;
        }

        $reqNumber = 'REQ-' . date('Y') . '-' . rand(100, 999);

        $maintenanceReq = MaintenanceRequest::create([
            'company_id' => $company->id,
            'facility_id' => $request->facility_id,
            'requester_id' => $user['id'] ?? null,
            'request_number' => $reqNumber,
            'type' => $request->type,
            'priority' => $request->priority,
            'system_type' => $request->system_type,
            'title' => $request->title,
            'description' => $request->description,
            'site_photos' => $photos,
            'status' => 'pending',
            'preferred_date' => $request->preferred_date ? Carbon::parse($request->preferred_date) : Carbon::now(),
        ]);

        // Create alert notification
        SystemNotification::create([
            'company_id' => $company->id,
            'user_id' => null,
            'type' => 'new_maintenance_request',
            'title' => "📥 طلب صيانة جديد #{$reqNumber}",
            'message' => "طلب ({$request->title}) من منشأة ({$maintenanceReq->facility->name}).",
            'target_url' => route('dashboard.maintenance_requests.index'),
            'priority' => $request->priority === 'critical' ? 'urgent' : 'normal',
        ]);

        return back()->with('success', "تم رفع طلب الصيانة بنجاح برقم #{$reqNumber}");
    }

    public function convertToVisit(Request $request, $id)
    {
        $maintenanceReq = MaintenanceRequest::with('facility.activeContract')->findOrFail($id);
        $request->validate([
            'assigned_engineer_id' => 'required|exists:users,id',
            'scheduled_date' => 'required|date',
            'scheduled_time' => 'required',
        ]);

        $company = Company::first();
        $facility = $maintenanceReq->facility;
        $scheduledAt = Carbon::parse($request->scheduled_date . ' ' . $request->scheduled_time);

        $hasContract = $facility->activeContract()->exists();
        $contractId = $hasContract ? $facility->activeContract->id : null;
        $fee = $hasContract ? 0.00 : ($facility->zone_type === 'inside_city' ? $company->zone_rate_inside : $company->zone_rate_outside);
        $feeStatus = $hasContract ? 'covered_by_contract' : 'unpaid';

        $visitNumber = 'VST-' . rand(1000, 9999);

        $visit = Visit::create([
            'company_id' => $company->id,
            'facility_id' => $facility->id,
            'contract_id' => $contractId,
            'maintenance_request_id' => $maintenanceReq->id,
            'assigned_engineer_id' => $request->assigned_engineer_id,
            'assigned_supervisor_id' => session('user')['id'] ?? null,
            'visit_number' => $visitNumber,
            'visit_type' => $maintenanceReq->type === 'emergency' ? 'emergency' : 'corrective_maintenance',
            'scheduled_at' => $scheduledAt,
            'location_zone' => $facility->zone_type,
            'visit_fee' => $fee,
            'fee_status' => $feeStatus,
            'purpose' => $maintenanceReq->title . ': ' . $maintenanceReq->description,
            'status' => 'scheduled',
            'has_unpaid_parts' => false,
            'unpaid_parts_amount' => 0.00,
        ]);

        $maintenanceReq->update(['status' => 'scheduled']);

        return redirect()->route('dashboard.visits.manage', $visit->id)->with('success', "تم تحويل الطلب إلى زيارة ميدانية بنجاح برقم {$visitNumber}");
    }
}
