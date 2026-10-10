<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Visit;
use App\Models\VisitReport;
use App\Models\SystemNotification;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $user = session('user');
        $reports = VisitReport::with(['visit.facility', 'visit.engineer', 'engineer', 'approver'])->latest()->get();
        $visitsWithoutReports = Visit::with('facility')->whereDoesntHave('report')->get();

        return view('dashboard.reports', compact('reports', 'visitsWithoutReports', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'visit_id' => 'required|exists:visits,id',
            'overall_status' => 'required|in:passed,passed_with_notes,critical_action_required,failed',
            'summary' => 'required|string',
            'recommendations' => 'nullable|string',
            'client_signature_name' => 'nullable|string',
        ]);

        $visit = Visit::with('facility')->findOrFail($request->visit_id);
        $user = session('user');

        $checklist = [
            'fire_pumps' => $request->input('check_fire_pumps', 'pass'),
            'fire_alarm' => $request->input('check_fire_alarm', 'pass'),
            'sprinklers' => $request->input('check_sprinklers', 'pass'),
            'extinguishers' => $request->input('check_extinguishers', 'pass'),
            'emergency_exits' => $request->input('check_emergency_exits', 'pass'),
            'smoke_ventilation' => $request->input('check_smoke_ventilation', 'pass'),
        ];

        $reportNumber = 'REP-' . date('Y') . '-' . rand(100, 999);

        $report = VisitReport::updateOrCreate(
            ['visit_id' => $visit->id],
            [
                'engineer_id' => $user['id'] ?? $visit->assigned_engineer_id,
                'report_number' => $reportNumber,
                'summary' => $request->summary,
                'overall_status' => $request->overall_status,
                'checklist_results' => $checklist,
                'recommendations' => $request->recommendations,
                'engineer_notes' => $request->engineer_notes,
                'client_signature_name' => $request->client_signature_name,
                'status' => 'submitted',
            ]
        );

        // Update visit status to completed
        $visit->update(['status' => 'completed']);

        // Notification
        SystemNotification::create([
            'company_id' => $visit->company_id,
            'user_id' => null,
            'type' => 'report_submitted',
            'title' => "📄 تم إصدار تقرير فحص سلامة #{$reportNumber}",
            'message' => "تم إصدار تقرير فحص لموقع ({$visit->facility->name}) بحالة: {$report->overall_status_arabic}.",
            'target_url' => route('dashboard.reports.show', $report->id),
            'priority' => 'normal',
        ]);

        return redirect()->route('dashboard.reports.show', $report->id)->with('success', "تم إنشاء تقرير الفحص بنجاح برقم #{$reportNumber}");
    }

    public function show($id)
    {
        $report = VisitReport::with(['visit.facility', 'visit.items', 'visit.images', 'visit.engineer', 'engineer', 'approver'])->findOrFail($id);
        $company = Company::first();

        return view('dashboard.report_detail', compact('report', 'company'));
    }

    public function approve($id)
    {
        $report = VisitReport::findOrFail($id);
        $user = session('user');

        $report->update([
            'status' => 'approved',
            'approved_by_user_id' => $user['id'] ?? 1,
            'approved_at' => Carbon::now(),
        ]);

        return back()->with('success', 'تم اعتماد تقرير الفحص الفني رسمياً.');
    }
}
