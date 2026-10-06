<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MembershipController extends Controller
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

        $requests = [
            [
                'id' => 'REQ-8821',
                'facility' => 'مدارس الفرسان العالمية - فرع العليا',
                'type' => 'مجمع تعليمي',
                'city' => 'الرياض',
                'contact' => 'أ. عبدالمحسن الدوسري (0501112233)',
                'area' => '6,500 م²',
                'service' => 'عقد صيانة سنوي AMC + تجديد رخصة سلامة',
                'created_at' => 'منذ ساعتين',
                'status' => 'pending'
            ],
            [
                'id' => 'REQ-8822',
                'facility' => 'مصنع الشرق للصناعات الكيماوية',
                'type' => 'مصنع كيميائي',
                'city' => 'الجبيل الصناعية',
                'contact' => 'م. خالد المنصور (0554443322)',
                'area' => '14,000 م²',
                'service' => 'شبكة رغوة فوم + رخصة مدن والدفاع المدني',
                'created_at' => 'منذ 5 ساعات',
                'status' => 'pending'
            ],
            [
                'id' => 'REQ-8820',
                'facility' => 'مستودعات الوطنية للتوزيع',
                'type' => 'مستودع تجاري',
                'city' => 'جدة - الخمرة',
                'contact' => 'أ. فهد الزهراني (0567778899)',
                'area' => '8,200 م²',
                'service' => 'عقد صيانة دوري AMC + فحص مضخات',
                'created_at' => 'أمس',
                'status' => 'approved'
            ],
        ];

        return view('dashboard.memberships', compact('user', 'requests'));
    }

    public function store(Request $request)
    {
        return redirect()->route('membership')->with('success', 'تم استلام طلبكم بنجاح وتم فتح ملف رقمي مؤقت برقم #REQ-' . rand(1000, 9999));
    }
}
