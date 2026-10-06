<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssetController extends Controller
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

        $assets = [
            [
                'code' => 'QR-EXT-8821',
                'name' => 'طفاية بودرة كيميائية 6 كجم ABC',
                'facility' => 'مدارس الأندلس الأهلية',
                'location' => 'مبنى البنين - معمل الكيمياء (الدور الثاني)',
                'last_inspection' => '2026-10-06 10:30 ص',
                'inspector' => 'سالم الدوسري',
                'status' => 'سليمة 100%',
                'status_badge' => 'emerald',
                'expiry' => '2027-05-15'
            ],
            [
                'code' => 'QR-PUMP-401',
                'name' => 'مضخة حريق ديزل رئيسية 750 GPM',
                'facility' => 'مصنع الخزف والبلاستيك السعودي',
                'location' => 'غرفة المضخات المركزية الخارجية',
                'last_inspection' => '2026-10-06 09:15 ص',
                'inspector' => 'م. أحمد القحطاني',
                'status' => 'الضغط 135 PSI (سليم)',
                'status_badge' => 'emerald',
                'expiry' => '2027-07-14'
            ],
            [
                'code' => 'QR-PANEL-109',
                'name' => 'لوحة تحكم إنذار Simplex 4100ES المعنونة',
                'facility' => 'مستودعات أجيليتي اللوجستية',
                'location' => 'غرفة المراقبة والتحكم الرئيسية',
                'last_inspection' => '2026-10-05 02:00 م',
                'inspector' => 'م. فيصل الغامدي',
                'status' => 'جميع الـ Loops متصلة',
                'status_badge' => 'emerald',
                'expiry' => '2027-04-14'
            ],
            [
                'code' => 'QR-HOSE-302',
                'name' => 'صندوق خرطوم حريق مطاطي 30 متر مع قاذف',
                'facility' => 'مدارس الأندلس الأهلية',
                'location' => 'مبنى الروضة - الممر الشرقي',
                'last_inspection' => '2026-10-04 11:45 ص',
                'inspector' => 'سالم الدوسري',
                'status' => 'مختبر تحت الضغط',
                'status_badge' => 'emerald',
                'expiry' => '2027-10-31'
            ],
        ];

        return view('dashboard.assets', compact('user', 'assets'));
    }
}
