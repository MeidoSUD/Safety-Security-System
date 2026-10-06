<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $user = session('user', [
            'role' => 'admin',
            'name' => 'م. عبدالرحمن المنصور',
            'title' => 'المدير التنفيذي (Admin)',
            'avatar' => '👑',
            'email' => 'admin@nabico.sa',
        ]);

        $rolesList = [
            [
                'key' => 'admin',
                'name' => 'الأدمن / الإدارة العليا (Admin)',
                'badge' => 'صلاحيات كاملة',
                'users_count' => 3,
                'description' => 'التحكم الشامل بكافة الموديلات، النماذج، الأسعار، وإعدادات النظام والموظفين.',
                'permissions' => [
                    'manage_contracts' => true,
                    'manage_templates' => true,
                    'manage_pricing' => true,
                    'manage_users' => true,
                    'view_financials' => true,
                    'approve_requests' => true
                ]
            ],
            [
                'key' => 'manager',
                'name' => 'مدير العمليات والعقود (Operations Manager)',
                'badge' => 'إدارة التشغيل',
                'users_count' => 5,
                'description' => 'إدارة العقود، اعتماد الزيارات الميدانية، متابعة الإشعارات وربط رخص سلامة.',
                'permissions' => [
                    'manage_contracts' => true,
                    'manage_templates' => false,
                    'manage_pricing' => true,
                    'manage_users' => false,
                    'view_financials' => true,
                    'approve_requests' => true
                ]
            ],
            [
                'key' => 'supervisor',
                'name' => 'مشرف الميدان والفنيين (Field Supervisor)',
                'badge' => 'إشراف ميداني',
                'users_count' => 12,
                'description' => 'متابعة جولات الفحص، استلام وتوزيع المهام، تدقيق تقارير الفنيين.',
                'permissions' => [
                    'manage_contracts' => false,
                    'manage_templates' => false,
                    'manage_pricing' => false,
                    'manage_users' => false,
                    'view_financials' => false,
                    'approve_requests' => true
                ]
            ],
            [
                'key' => 'technician',
                'name' => 'الفني / التقني (Field Technician)',
                'badge' => 'تنفيذ ميداني',
                'users_count' => 28,
                'description' => 'سحب وتعبئة التقارير الفنية في الموقع، تسجيل قراءات الضغط، رفع الصور والملاحظات.',
                'permissions' => [
                    'manage_contracts' => false,
                    'manage_templates' => false,
                    'manage_pricing' => false,
                    'manage_users' => false,
                    'view_financials' => false,
                    'approve_requests' => false
                ]
            ],
            [
                'key' => 'client',
                'name' => 'العميل / المنشأة (Client Portal)',
                'badge' => 'بوابة خارجية',
                'users_count' => 148,
                'description' => 'استعراض العقود والشهادات، تنزيل تقارير الدفاع المدني، وطلب زيارة طارئة.',
                'permissions' => [
                    'manage_contracts' => false,
                    'manage_templates' => false,
                    'manage_pricing' => false,
                    'manage_users' => false,
                    'view_financials' => false,
                    'approve_requests' => false
                ]
            ]
        ];

        return view('dashboard.permissions', compact('user', 'rolesList'));
    }
}
