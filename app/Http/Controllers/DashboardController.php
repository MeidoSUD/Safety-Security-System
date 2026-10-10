<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Contract;
use App\Models\Facility;
use App\Models\MaintenanceRequest;
use App\Models\Visit;
use App\Models\VisitItem;
use App\Models\VisitReport;
use App\Models\InternalRequest;
use App\Models\SystemNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userSession = session('user', [
            'id' => 1,
            'role' => 'admin',
            'name' => 'م. عبدالرحمن المنصور',
            'title' => 'المدير التنفيذي (Admin)',
            'avatar' => '👑',
            'email' => 'admin@nabico.sa',
        ]);

        $role = $userSession['role'] ?? 'admin';
        $userId = $userSession['id'] ?? 1;
        $currentUser = User::find($userId) ?? User::where('role', $role)->first();
        $company = Company::first();

        // 1. Role-Specific Data & Statistics
        if ($role === 'client') {
            // Client Portal: Only the client's facilities and tickets
            $clientFacilities = Facility::with(['activeContract', 'visits'])->where('client_user_id', $userId)->get();
            if ($clientFacilities->isEmpty()) {
                $clientFacilities = Facility::with(['activeContract', 'visits'])->where('name', 'LIKE', '%الأندلس%')->get();
            }
            $facilityIds = $clientFacilities->pluck('id')->toArray();

            $clientContracts = Contract::whereIn('facility_id', $facilityIds)->get();
            $clientVisits = Visit::with(['facility', 'engineer', 'report'])
                ->whereIn('facility_id', $facilityIds)
                ->latest('scheduled_at')
                ->get();
            $clientRequests = MaintenanceRequest::whereIn('facility_id', $facilityIds)->latest()->get();
            $clientReports = VisitReport::whereHas('visit', function($q) use ($facilityIds) {
                $q->whereIn('facility_id', $facilityIds);
            })->latest()->get();

            $stats = [
                'my_facilities_count' => $clientFacilities->count(),
                'active_contracts_count' => $clientContracts->where('status', 'active')->count(),
                'upcoming_visits_count' => $clientVisits->where('status', 'scheduled')->count(),
                'my_requests_count' => $clientRequests->count(),
                'my_reports_count' => $clientReports->count(),
                'safety_compliance_score' => 98, // Percentage
            ];

            $notifications = SystemNotification::where('user_id', $userId)
                ->orWhereNull('user_id')
                ->latest()
                ->take(5)
                ->get();

            return view('dashboard.index', compact('userSession', 'currentUser', 'company', 'role', 'stats', 'clientFacilities', 'clientContracts', 'clientVisits', 'clientRequests', 'clientReports', 'notifications'));

        } elseif ($role === 'technician') {
            // Field Technician / Engineer: Only tasks and visits assigned to this technician
            $assignedVisits = Visit::with(['facility', 'supervisor', 'items', 'images', 'report'])
                ->where('assigned_engineer_id', $userId)
                ->latest('scheduled_at')
                ->get();

            if ($assignedVisits->isEmpty()) {
                $assignedVisits = Visit::with(['facility', 'supervisor', 'items', 'images', 'report'])->latest('scheduled_at')->get();
            }

            $todayVisits = $assignedVisits->filter(function($v) {
                return $v->scheduled_at->isToday() || $v->status === 'in_progress';
            });

            $completedVisits = $assignedVisits->where('status', 'completed');
            $pendingReportsCount = $assignedVisits->where('status', '!=', 'completed')->whereNull('report')->count();
            $myReplacedPartsCount = VisitItem::whereHas('visit', function($q) use ($userId) {
                $q->where('assigned_engineer_id', $userId);
            })->count();

            $stats = [
                'today_visits_count' => $todayVisits->count(),
                'assigned_total_count' => $assignedVisits->count(),
                'in_progress_count' => $assignedVisits->where('status', 'in_progress')->count(),
                'completed_count' => $completedVisits->count(),
                'pending_reports_count' => $pendingReportsCount,
                'replaced_parts_count' => $myReplacedPartsCount,
            ];

            $notifications = SystemNotification::where('user_id', $userId)
                ->orWhereNull('user_id')
                ->latest()
                ->take(5)
                ->get();

            return view('dashboard.index', compact('userSession', 'currentUser', 'company', 'role', 'stats', 'assignedVisits', 'todayVisits', 'notifications'));

        } elseif ($role === 'supervisor') {
            // Field Supervisor: Field dispatch, inspection verification, technician status
            $supervisorVisits = Visit::with(['facility', 'engineer', 'items', 'report'])->latest('scheduled_at')->get();
            $techniciansList = User::where('role', 'technician')->withCount('assignedVisitsAsEngineer')->get();
            $unpaidVisits = Visit::with('facility')->where('has_unpaid_parts', true)->get();
            $pendingReviewReports = VisitReport::with(['visit.facility', 'engineer'])->where('status', 'submitted')->get();

            $stats = [
                'field_visits_today' => $supervisorVisits->where('status', 'scheduled')->count(),
                'active_in_field' => $supervisorVisits->where('status', 'in_progress')->count(),
                'unpaid_parts_count' => $unpaidVisits->count(),
                'unpaid_parts_total' => $unpaidVisits->sum('unpaid_parts_amount'),
                'pending_reports_review' => $pendingReviewReports->count(),
                'active_technicians' => $techniciansList->count(),
            ];

            $notifications = SystemNotification::latest()->take(6)->get();

            return view('dashboard.index', compact('userSession', 'currentUser', 'company', 'role', 'stats', 'supervisorVisits', 'techniciansList', 'unpaidVisits', 'pendingReviewReports', 'notifications'));

        } elseif ($role === 'manager') {
            // Operations & Contract Manager
            $stats = [
                'active_contracts' => Contract::where('status', 'active')->count(),
                'expiring_contracts' => Contract::where('status', 'expiring_soon')->orWhere('end_date', '<=', Carbon::now()->addDays(30))->count(),
                'total_facilities' => Facility::count(),
                'pending_requests' => MaintenanceRequest::where('status', 'pending')->count(),
                'scheduled_visits' => Visit::where('status', 'scheduled')->count(),
                'unpaid_parts_total' => Visit::where('has_unpaid_parts', true)->sum('unpaid_parts_amount'),
                'internal_requests_pending' => InternalRequest::where('status', 'pending')->count(),
            ];

            $contractsList = Contract::with('facility')->latest()->take(5)->get();
            $recentVisits = Visit::with(['facility', 'engineer'])->latest('scheduled_at')->take(5)->get();
            $pendingRequests = MaintenanceRequest::with('facility')->where('status', 'pending')->get();
            $internalRequests = InternalRequest::with('requester')->where('status', 'pending')->get();
            $notifications = SystemNotification::latest()->take(6)->get();

            return view('dashboard.index', compact('userSession', 'currentUser', 'company', 'role', 'stats', 'contractsList', 'recentVisits', 'pendingRequests', 'internalRequests', 'notifications'));

        } else {
            // Admin (Executive General Management)
            $stats = [
                'total_facilities' => Facility::count(),
                'active_contracts' => Contract::where('status', 'active')->count(),
                'total_contracts_value' => Contract::where('status', 'active')->sum('total_amount'),
                'scheduled_visits' => Visit::where('status', 'scheduled')->count(),
                'in_progress_visits' => Visit::where('status', 'in_progress')->count(),
                'completed_visits' => Visit::where('status', 'completed')->count(),
                'pending_requests' => MaintenanceRequest::where('status', 'pending')->count(),
                'unpaid_parts_count' => Visit::where('has_unpaid_parts', true)->count(),
                'unpaid_parts_total' => Visit::where('has_unpaid_parts', true)->sum('unpaid_parts_amount'),
                'internal_requests_pending' => InternalRequest::where('status', 'pending')->count(),
                'total_users' => User::count(),
            ];

            $recentVisits = Visit::with(['facility', 'engineer', 'supervisor', 'items', 'report'])->latest('scheduled_at')->take(5)->get();
            $recentRequests = MaintenanceRequest::with(['facility', 'requester'])->latest()->take(4)->get();
            $notifications = SystemNotification::latest()->take(6)->get();

            return view('dashboard.index', compact('userSession', 'currentUser', 'company', 'role', 'stats', 'recentVisits', 'recentRequests', 'notifications'));
        }
    }
}
