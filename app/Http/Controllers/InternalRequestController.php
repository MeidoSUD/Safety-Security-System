<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InternalRequestController extends Controller
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

        $internalRequests = [
            [
                'id' => 'INT-2026-101',
                'title' => 'طلب توفير حساسات غاز وكواشف شعاع ليزري Beam من المستودع',
                'from_dept' => 'إدارة العمليات الميدانية',
                'to_dept' => 'إدارة المشتريات والمستودعات',
                'priority' => 'عالية (High)',
                'priority_badge' => 'red',
                'created_by' => 'م. طارق الشمري',
                'date' => '2026-10-06 09:30 ص',
                'facility_ref' => 'مستودعات أجيليتي اللوجستية',
                'details' => 'يرجى توفير عدد 4 كواشف شعاع ليزري و2 لوحة إنذار مساعدة لتجهيز زيارة الصيانة الوقائية القادمة.',
                'status' => 'in_progress',
                'status_label' => 'قيد المعالجة (In Progress)',
                'status_badge' => 'amber'
            ],
            [
                'id' => 'INT-2026-102',
                'title' => 'طلب تدقيق واعتماد مخطط سلامة هندسي وتوقيع شهادة الإنجاز',
                'from_dept' => 'إدارة المبيعات والعقود',
                'to_dept' => 'الإدارة الهندسية والاستشارات',
                'priority' => 'حرجة / طارئة (Urgent)',
                'priority_badge' => 'red',
                'created_by' => 'أ. عبدالمحسن الدوسري',
                'date' => '2026-10-06 11:15 ص',
                'facility_ref' => 'مصنع الخزف والبلاستيك السعودي',
                'details' => 'العميل بصدد تجديد رخصة مدن والدفاع المدني ويحتاج إلى توقيع المهندس المعتمد ورفع التقرير على منصة سلامة خلال 24 ساعة.',
                'status' => 'assigned',
                'status_label' => 'تم التوجيه للمهندس (Assigned)',
                'status_badge' => 'blue'
            ],
            [
                'id' => 'INT-2026-103',
                'title' => 'طلب إصدار إشعار مطالبة مالية لقطع غيار مضخات ديزل غير مسددة',
                'from_dept' => 'إدارة الصيانة والتشغيل',
                'to_dept' => 'الإدارة المالية والتحصيل',
                'priority' => 'متوسطة (Medium)',
                'priority_badge' => 'amber',
                'created_by' => 'سالم الدوسري',
                'date' => '2026-10-05 02:40 م',
                'facility_ref' => 'مجمع دار الرعاية الطبي',
                'details' => 'تم تركيب محابس وفلاتر زيت بقيمة 4,800 ر.س مع تقرير الفحص ولم يتم سداد القيمة من قبل إدارة المستشفى.',
                'status' => 'new',
                'status_label' => 'طلب جديد (New)',
                'status_badge' => 'purple'
            ],
            [
                'id' => 'INT-2026-098',
                'title' => 'طلب صرف سيارة صيانة مجهزة إضافية لفرق المنطقة الشرقية',
                'from_dept' => 'إدارة العمليات الميدانية',
                'to_dept' => 'الخدمات المساندة والحركة',
                'priority' => 'عادية (Low)',
                'priority_badge' => 'slate',
                'created_by' => 'م. أحمد القحطاني',
                'date' => '2026-10-03 08:00 ص',
                'facility_ref' => 'فرع الدمام والجبيل',
                'details' => 'لتغطية التوسع في عقود مصانع الجبيل الصناعية 2.',
                'status' => 'completed',
                'status_label' => 'مكتمل ومغلق (Completed)',
                'status_badge' => 'emerald'
            ],
        ];

        return view('dashboard.internal_requests', compact('user', 'internalRequests'));
    }
}
