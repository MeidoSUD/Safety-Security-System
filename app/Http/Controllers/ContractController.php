<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContractController extends Controller
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

        $contracts = [
            [
                'id' => 'NBC-2026-88',
                'facility' => 'مجمع مدارس الأندلس الأهلية للبنين والبنات',
                'type' => 'مدرسة / مجمع تعليمي',
                'type_badge' => 'blue',
                'city' => 'الرياض - حي النرجس',
                'value' => '65,000 ر.س',
                'sensitivity' => 'high',
                'sensitivity_label' => 'عالي الحساسية (طلاب ومنشأة تعليمية)',
                'sensitivity_badge' => 'red',
                'start_date' => '2025-11-01',
                'end_date' => '2026-10-31',
                'days_remaining' => 25,
                'status' => 'expiring',
                'status_label' => 'قارب على الانتهاء',
                'status_badge' => 'amber',
                'salamah_status' => 'سارية',
                'engineer' => 'م. طارق الشمري',
                'supervisor' => 'سالم الدوسري',
                'sites' => [
                    ['name' => 'مبنى البنين الرئيسي (4 أدوار + صالة مغلقة)', 'area' => '4,800 م²', 'systems' => 'رش آلي + مضخات ديزل 500 GPM + إنذار Simplex'],
                    ['name' => 'مبنى الروضة والمرحلة الابتدائية', 'area' => '2,200 م²', 'systems' => 'كواشف دخان معنونة + مخارج طوارئ + 48 طفاية']
                ],
                'equipment_count' => 142,
                'last_visit' => '2026-09-15',
                'next_visit' => '2026-10-15',
                'attachments' => [
                    'contract_copy' => ['name' => 'عقد_صيانة_مدارس_الأندلس_2026.pdf', 'size' => '2.4 MB', 'uploaded_at' => '2025-11-01'],
                    'quotation' => ['name' => 'عرض_سعر_معتمد_نبيكو_Q88.pdf', 'size' => '1.1 MB', 'uploaded_at' => '2025-10-25'],
                    'payment_proof' => ['name' => 'إشعار_تحويل_بنكي_مصرف_الراجحي_32500.pdf', 'size' => '850 KB', 'uploaded_at' => '2025-11-02'],
                    'notes_attachment' => ['name' => 'اشتراطات_مختبر_الكيمياء_والسلامة.pdf', 'size' => '540 KB', 'uploaded_at' => '2025-11-05'],
                ]
            ],
            [
                'id' => 'NBC-2026-104',
                'facility' => 'مصنع الخزف والبلاستيك السعودي',
                'type' => 'مصنع / منشأة صناعية',
                'type_badge' => 'orange',
                'city' => 'الدمام - المدينة الصناعية الثانية',
                'value' => '120,000 ر.س',
                'sensitivity' => 'high',
                'sensitivity_label' => 'عالي الخطورة والحساسية (مواد بتروكيماوية)',
                'sensitivity_badge' => 'red',
                'start_date' => '2026-07-15',
                'end_date' => '2027-07-14',
                'days_remaining' => 281,
                'status' => 'active',
                'status_label' => 'ساري ونشط',
                'status_badge' => 'emerald',
                'salamah_status' => 'سارية',
                'engineer' => 'م. أحمد القحطاني',
                'supervisor' => 'فهد المطيري',
                'sites' => [
                    ['name' => 'مبنى خط الإنتاج الرئيسي ومستودع المواد الخام', 'area' => '12,500 م²', 'systems' => 'Foam Deluge + شبكة رش رغوي + مضخات 750 GPM'],
                    ['name' => 'غرفة التحكم ولوحات التوزيع الكهربائية', 'area' => '850 م²', 'systems' => 'أنظمة إطفاء غاز FM200 وNovec 1230']
                ],
                'equipment_count' => 280,
                'last_visit' => '2026-09-28',
                'next_visit' => '2026-10-28',
                'attachments' => [
                    'contract_copy' => ['name' => 'عقد_صيانة_مصنع_الخزف_السعودي_2026.pdf', 'size' => '4.2 MB', 'uploaded_at' => '2026-07-15'],
                    'quotation' => ['name' => 'الكوتيشن_المالي_المعتمد_مدن_Q104.pdf', 'size' => '1.8 MB', 'uploaded_at' => '2026-07-02'],
                    'payment_proof' => ['name' => 'حوالة_بنك_الأهلي_الدفعة_الأولى_60000.pdf', 'size' => '1.2 MB', 'uploaded_at' => '2026-07-16'],
                    'notes_attachment' => ['name' => 'ملاحظات_الفحص_الخاص_بأنظمة_الفوم.pdf', 'size' => '920 KB', 'uploaded_at' => '2026-07-20'],
                ]
            ],
            [
                'id' => 'NBC-2026-119',
                'facility' => 'مستودعات أجيليتي اللوجستية المركزية',
                'type' => 'مستودع لوجستي',
                'type_badge' => 'emerald',
                'city' => 'جدة - منطقة الخمرة اللوجستية',
                'value' => '95,000 ر.س',
                'sensitivity' => 'medium',
                'sensitivity_label' => 'متوسط الحساسية (تخزين جاف ومبرد)',
                'sensitivity_badge' => 'amber',
                'start_date' => '2026-04-15',
                'end_date' => '2027-04-14',
                'days_remaining' => 190,
                'status' => 'active',
                'status_label' => 'ساري ونشط',
                'status_badge' => 'emerald',
                'salamah_status' => 'سارية',
                'engineer' => 'م. فيصل الغامدي',
                'supervisor' => 'عمر الحربي',
                'sites' => [
                    ['name' => 'هنجر التخزين المبرد والجاف (ارتفاع 14 متر)', 'area' => '18,000 م²', 'systems' => 'شبكة رش ESFR + 32 كاشف شعاع ليزري Beam']
                ],
                'equipment_count' => 195,
                'last_visit' => '2026-09-10',
                'next_visit' => '2026-11-10',
                'attachments' => [
                    'contract_copy' => ['name' => 'عقد_أجيليتي_الخمرة_2026.pdf', 'size' => '3.1 MB', 'uploaded_at' => '2026-04-15'],
                    'quotation' => ['name' => 'عرض_السعر_النهائي_Q119.pdf', 'size' => '980 KB', 'uploaded_at' => '2026-04-05'],
                    'payment_proof' => ['name' => 'سند_قبض_بنك_الرياض_47500.pdf', 'size' => '650 KB', 'uploaded_at' => '2026-04-16'],
                    'notes_attachment' => ['name' => 'مخطط_مسارات_الرافعات_الشوكية.pdf', 'size' => '1.5 MB', 'uploaded_at' => '2026-04-18'],
                ]
            ],
            [
                'id' => 'NBC-2025-42',
                'facility' => 'مجمع دار الرعاية الطبي التخصصي',
                'type' => 'مستشفى / مركز طبي',
                'type_badge' => 'purple',
                'city' => 'الرياض - حي الملز',
                'value' => '78,000 ر.س',
                'sensitivity' => 'high',
                'sensitivity_label' => 'عالي الحساسية (مرضى وعناية مركزة)',
                'sensitivity_badge' => 'red',
                'start_date' => '2025-09-01',
                'end_date' => '2026-08-31',
                'days_remaining' => -36,
                'status' => 'expired',
                'status_label' => 'منتهي الصلاحية',
                'status_badge' => 'red',
                'salamah_status' => 'متوقفة',
                'engineer' => 'م. طارق الشمري',
                'supervisor' => 'سالم الدوسري',
                'sites' => [
                    ['name' => 'المبنى الرئيسي للعيادات والتنويم', 'area' => '5,400 م²', 'systems' => 'حساسات إنذار ذكية + أبواب طوارئ مغناطيسية']
                ],
                'equipment_count' => 110,
                'last_visit' => '2026-08-20',
                'next_visit' => 'متوقف للتجديد',
                'attachments' => [
                    'contract_copy' => ['name' => 'عقد_دار_الرعاية_2025_منتهي.pdf', 'size' => '2.8 MB', 'uploaded_at' => '2025-09-01'],
                    'quotation' => ['name' => 'كوتيشن_المستشفى_السنوي.pdf', 'size' => '1.4 MB', 'uploaded_at' => '2025-08-15'],
                    'payment_proof' => ['name' => 'إشعار_سداد_سابق.pdf', 'size' => '720 KB', 'uploaded_at' => '2025-09-05'],
                    'notes_attachment' => ['name' => 'ملاحظات_قسم_الغازات_الطبية.pdf', 'size' => '890 KB', 'uploaded_at' => '2025-09-10'],
                ]
            ],
        ];

        return view('dashboard.contracts', compact('user', 'contracts'));
    }
}
