<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Contract;
use App\Models\Facility;
use App\Models\MaintenanceRequest;
use App\Models\Visit;
use App\Models\VisitItem;
use App\Models\InternalRequest;
use App\Models\SystemNotification;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
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

        // Database Metrics
        $stats = [
            'total_facilities' => Facility::count(),
            'active_contracts' => Contract::where('status', 'active')->count(),
            'scheduled_visits' => Visit::where('status', 'scheduled')->count(),
            'in_progress_visits' => Visit::where('status', 'in_progress')->count(),
            'completed_visits' => Visit::where('status', 'completed')->count(),
            'pending_requests' => MaintenanceRequest::where('status', 'pending')->count(),
            'unpaid_parts_count' => Visit::where('has_unpaid_parts', true)->count(),
            'unpaid_parts_total' => Visit::where('has_unpaid_parts', true)->sum('unpaid_parts_amount'),
            'internal_requests_pending' => InternalRequest::where('status', 'pending')->count(),
        ];

        // Recent Visits
        $recentVisits = Visit::with(['facility', 'engineer', 'supervisor', 'items', 'report'])
            ->latest('scheduled_at')
            ->take(5)
            ->get();

        // Recent Maintenance Requests
        $recentRequests = MaintenanceRequest::with(['facility', 'requester'])
            ->latest()
            ->take(4)
            ->get();

        // Notifications
        $notifications = SystemNotification::latest()->take(6)->get();

        return view('dashboard.index', compact('user', 'company', 'stats', 'recentVisits', 'recentRequests', 'notifications'));
    }
}
