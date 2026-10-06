<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
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

        // Report Templates (Configurable by Admin)
        $templates = [
            [
                'id' => 'TPL-01',
                'name' => 'نموذج الفحص الشامل لمضخات الحريق وشبكات الرش الآلي',
                'fields_count' => 14,
                'category' => 'مكافحة الحريق',
                'last_updated' => '2026-09-20',
                'updated_by' => 'م. عبدالرحمن المنصور (Admin)',
                'is_active' => true
            ],
            [
                'id' => 'TPL-02',
                'name' => 'نموذج فحص واختبار لوحات الإنذار وكواشف الدخان والحرارة',
                'fields_count' => 10,
                'category' => 'الإنذار المبكر',
                'last_updated' => '2026-09-18',
                'updated_by' => 'م. طارق الشمري',
                'is_active' => true
            ],
            [
                'id' => 'TPL-03',
                'name' => 'استمارة فحص أنظمة الإطفاء الغازية (FM200 / Novec / CO2)',
                'fields_count' => 12,
                'category' => 'أنظمة خاصة للمصانع والسيرفرات',
                'last_updated' => '2026-08-30',
                'updated_by' => 'م. عبدالرحمن المنصور (Admin)',
                'is_active' => true
            ],
            [
                'id' => 'TPL-04',
                'name' => 'استمارة الكشف الدوري والوقائي للمدارس والمنشآت التعليمية',
                'fields_count' => 16,
                'category' => 'قطاع التعليم',
                'last_updated' => '2026-09-05',
                'updated_by' => 'م. عبدالرحمن المنصور (Admin)',
                'is_active' => true
            ],
        ];

        // Issued Reports
        $issuedReports = [
            [
                'number' => 'SLM-2026-9941',
                'facility' => 'مجمع مدارس الأندلس الأهلية',
                'template_used' => 'استمارة الكشف الدوري والوقائي للمدارس',
                'type' => 'شهادة سلامة معتمدة (منصة سلامة)',
                'date' => '2026-09-15',
                'engineer' => 'م. طارق الشمري',
                'status' => 'سارية ومعتمدة',
                'status_badge' => 'emerald',
                'attachment_file' => 'شهادة_سلامة_الأندلس_9941.pdf'
            ],
            [
                'number' => 'TECH-2026-104',
                'facility' => 'مصنع الخزف والبلاستيك السعودي',
                'template_used' => 'استمارة فحص أنظمة الإطفاء الغازية ورغوة الفوم',
                'type' => 'تقرير معاينة واختبار أنظمة الغاز ورغوة الفوم',
                'date' => '2026-09-28',
                'engineer' => 'م. أحمد القحطاني',
                'status' => 'معتمد من مدن والدفاع المدني',
                'status_badge' => 'emerald',
                'attachment_file' => 'تقرير_فحص_الخزف_104.pdf'
            ],
            [
                'number' => 'SLM-2026-119',
                'facility' => 'مستودعات أجيليتي اللوجستية المركزية',
                'template_used' => 'نموذج الفحص الشامل لمضخات الحريق وشبكات الرش',
                'type' => 'شهادة كفاءة فنية لمستودع تخزين عالي',
                'date' => '2026-09-10',
                'engineer' => 'م. فيصل الغامدي',
                'status' => 'سارية حتى 2027',
                'status_badge' => 'emerald',
                'attachment_file' => 'شهادة_كفاءة_أجيليتي_119.pdf'
            ],
        ];

        return view('dashboard.reports', compact('user', 'templates', 'issuedReports'));
    }
}
