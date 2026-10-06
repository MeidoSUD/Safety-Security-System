<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = session('user', [
            'role' => 'admin',
            'name' => 'م. عبدالرحمن المنصور',
            'title' => 'المدير التنفيذي (Admin)',
            'avatar' => '👑',
            'email' => 'admin@nabico.sa',
        ]);

        $stats = [
            'admin' => [
                'active_contracts' => 148,
                'expiring_soon' => 9,
                'pending_visits' => 34,
                'open_tickets' => 6,
                'total_revenue' => '3,850,000 ر.س',
                'collection_rate' => '94%',
            ],
            'manager' => [
                'active_contracts' => 148,
                'expiring_soon' => 9,
                'pending_visits' => 34,
                'open_tickets' => 4,
                'total_revenue' => '1,420,000 ر.س',
                'collection_rate' => '91%',
            ],
            'supervisor' => [
                'active_contracts' => 42,
                'expiring_soon' => 3,
                'pending_visits' => 14,
                'open_tickets' => 3,
                'total_revenue' => '420,000 ر.س',
                'collection_rate' => '98%',
            ],
            'technician' => [
                'active_contracts' => 12,
                'expiring_soon' => 1,
                'pending_visits' => 4,
                'open_tickets' => 2,
                'total_revenue' => '0 ر.س',
                'collection_rate' => '100%',
            ],
            'client' => [
                'active_contracts' => 1,
                'expiring_soon' => 1,
                'pending_visits' => 1,
                'open_tickets' => 0,
                'total_revenue' => '65,000 ر.س',
                'collection_rate' => 'مسدد 50%',
            ],
        ];

        $currentStats = $stats[$user['role']] ?? $stats['admin'];

        return view('dashboard.index', compact('user', 'currentStats'));
    }
}
