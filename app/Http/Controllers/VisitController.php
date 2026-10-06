<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VisitController extends Controller
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

        // Pricing Configuration for Pre-Contract / Non-Contractual visits
        $pricingConfig = [
            'inside_city' => [
                'name' => 'زيارات المعاينة داخل نطاق المدينة (Inside City Area)',
                'price' => 350,
                'description' => 'تشمل الفحص المبدئي، تقرير الكشف الأولي، ورفع التقرير لمهندس السلامة في نفس المدينة.',
                'coverage' => 'نطاق مدن: الرياض، جدة، الدمام، الجبيل، مكة المكرمة'
            ],
            'outside_city' => [
                'name' => 'زيارات المعاينة خارج نطاق المدينة والمناطق النائية (Outside City Area)',
                'price' => 650,
                'description' => 'تشمل أجور الانتقال للمواقع البعيدة والمجمعات الصناعية خارج النطاق العمراني.',
                'coverage' => 'المحافظات، المدن الصناعية البعيدة، والمواقع الإنشائية الخارجية'
            ],
        ];

        $visits = [
            [
                'id' => 'VST-991',
                'facility' => 'مصنع الخزف والبلاستيك السعودي',
                'contract_status' => 'متعاقد (عقد ساري)',
                'location_zone' => 'داخل نطاق المدينة (الدمام)',
                'visit_fee' => 'مغطى بالعقد السنوي',
                'type' => 'زيارة طارئة',
                'type_badge' => 'red',
                'city' => 'الدمام - المدينة الصناعية 2',
                'engineer' => 'م. أحمد القحطاني',
                'supervisor' => 'فهد المطيري',
                'time' => '10:30 ص (اليوم)',
                'purpose' => 'فحص ضغط مضخة الحريق الديزل واختبار التسريب بالمحبس الرئيسي',
                'status' => 'in_progress',
                'status_label' => 'قيد التنفيذ الآن',
                'status_badge' => 'amber',
                'has_unpaid_parts' => true,
                'unpaid_parts_amount' => '4,800 ر.س',
                'unpaid_parts_notes' => 'توجد ملاحظة فنية: تسريب في محبس عدم الرجوع (Check Valve) ولم يتم سداد قيمة القطعة من قبل العميل.',
                'report_attachment' => [
                    'name' => 'تقرير_معاينة_مضخات_الخزف_991.pdf',
                    'size' => '1.6 MB',
                    'status' => 'مسودة قيد التعبئة'
                ]
            ],
            [
                'id' => 'VST-992',
                'facility' => 'مجمع مدارس الأندلس الأهلية',
                'contract_status' => 'متعاقد (عقد ساري)',
                'location_zone' => 'داخل نطاق المدينة (الرياض)',
                'visit_fee' => 'مغطى بالعقد السنوي',
                'type' => 'فحص ربع سنوي Q3',
                'type_badge' => 'blue',
                'city' => 'الرياض - حي النرجس',
                'engineer' => 'م. طارق الشمري',
                'supervisor' => 'سالم الدوسري',
                'time' => '02:00 م (اليوم)',
                'purpose' => 'فحص 142 طفاية حريق وفحص كواشف الدخان في الفصول والمختبرات',
                'status' => 'scheduled',
                'status_label' => 'مجدول اليوم',
                'status_badge' => 'blue',
                'has_unpaid_parts' => false,
                'unpaid_parts_amount' => '0 ر.س',
                'unpaid_parts_notes' => '',
                'report_attachment' => [
                    'name' => 'جدول_فحص_الربع_الثالث_الأندلس.pdf',
                    'size' => '2.1 MB',
                    'status' => 'جاهز للاعتماد'
                ]
            ],
            [
                'id' => 'VST-995',
                'facility' => 'مستودعات الغانم المركزية (غير متعاقد - طلب معاينة)',
                'contract_status' => 'غير متعاقد (زيارة معاينة تمهيدية)',
                'location_zone' => 'خارج نطاق المدينة (طريق الخرج)',
                'visit_fee' => '650 ر.س (مسددة)',
                'type' => 'معاينة ما قبل التعاقد',
                'type_badge' => 'purple',
                'city' => 'الرياض - خارج النطاق (طريق الخرج)',
                'engineer' => 'م. طارق الشمري',
                'supervisor' => 'سالم الدوسري',
                'time' => 'غداً 09:00 ص',
                'purpose' => 'معاينة الموقع وتقدير كوتيشن أنظمة الإطفاء ورخصة سلامة',
                'status' => 'scheduled',
                'status_label' => 'مجدول',
                'status_badge' => 'blue',
                'has_unpaid_parts' => false,
                'unpaid_parts_amount' => '0 ر.س',
                'unpaid_parts_notes' => '',
                'report_attachment' => null
            ],
            [
                'id' => 'VST-989',
                'facility' => 'مجمع دار الرعاية الطبي',
                'contract_status' => 'عقد منتهي الصلاحية',
                'location_zone' => 'داخل نطاق المدينة (الرياض)',
                'visit_fee' => '350 ر.س (معلق)',
                'type' => 'زيارة طارئة لعطل إنذار',
                'type_badge' => 'red',
                'city' => 'الرياض - حي الملز',
                'engineer' => 'م. طارق الشمري',
                'supervisor' => 'سالم الدوسري',
                'time' => 'أمس 11:00 ص',
                'purpose' => 'إصلاح عطل متكرر في لوحة الإنذار بالدور الثالث',
                'status' => 'completed',
                'status_label' => 'مكتملة مع ملاحظات ⚠️',
                'status_badge' => 'amber',
                'has_unpaid_parts' => true,
                'unpaid_parts_amount' => '2,300 ر.س',
                'unpaid_parts_notes' => '⚠️ تم تركيب كواشف جديدة ولوحة إمداد طاقة ولم يتم سداد قيمة قطع الغيار حتى الآن.',
                'report_attachment' => [
                    'name' => 'تقرير_عطل_لوحة_إنذار_دار_الرعاية.pdf',
                    'size' => '1.9 MB',
                    'status' => 'مكتمل ومرفق'
                ]
            ],
        ];

        return view('dashboard.visits', compact('user', 'visits', 'pricingConfig'));
    }
}
