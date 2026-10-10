<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use App\Models\Facility;
use App\Models\Contract;
use App\Models\MaintenanceRequest;
use App\Models\Visit;
use App\Models\VisitImage;
use App\Models\VisitItem;
use App\Models\VisitReport;
use App\Models\InternalRequest;
use App\Models\SystemNotification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Demo Safety SaaS Company (Tenant 1)
        $company = Company::create([
            'name' => 'شركة نبيكو العربية للتشغيل والصيانة والسلامة',
            'cr_number' => '1010482910',
            'tax_number' => '300482910200003',
            'email' => 'info@nabico.sa',
            'phone' => '920000000',
            'city' => 'الرياض',
            'address' => 'طريق الملك فهد، حي الصحافة، الرياض',
            'subscription_plan' => 'enterprise',
            'subscription_status' => 'active',
            'zone_rate_inside' => 350.00,
            'zone_rate_outside' => 650.00,
            'sms_reminder_enabled' => true,
        ]);

        // Tenant 2 (Demo for SaaS Selling)
        $company2 = Company::create([
            'name' => 'شركة وقاية الشرق لحلول السلامة المتقدمة',
            'cr_number' => '2050198273',
            'tax_number' => '300817263500003',
            'email' => 'contact@weqaya-safety.sa',
            'phone' => '920055443',
            'city' => 'الدمام',
            'address' => 'طريق الملك فيصل، الخبر',
            'subscription_plan' => 'pro',
            'subscription_status' => 'trial',
            'zone_rate_inside' => 400.00,
            'zone_rate_outside' => 700.00,
            'sms_reminder_enabled' => true,
        ]);

        // 2. Create Multi-Role Users
        $admin = User::create([
            'company_id' => $company->id,
            'name' => 'م. عبدالرحمن المنصور',
            'email' => 'admin@nabico.sa',
            'phone' => '0501112233',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'job_title' => 'المدير التنفيذي (Admin)',
            'avatar_emoji' => '👑',
            'is_active' => true,
        ]);

        $manager = User::create([
            'company_id' => $company->id,
            'name' => 'أ. طارق الشمري',
            'email' => 'manager@nabico.sa',
            'phone' => '0502223344',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'job_title' => 'مدير العمليات والعقود',
            'avatar_emoji' => '🏢',
            'is_active' => true,
        ]);

        $supervisor = User::create([
            'company_id' => $company->id,
            'name' => 'سالم الدوسري',
            'email' => 'supervisor@nabico.sa',
            'phone' => '0503334455',
            'password' => Hash::make('password'),
            'role' => 'supervisor',
            'job_title' => 'مشرف الميدان والفنيين',
            'avatar_emoji' => '🛡️',
            'is_active' => true,
        ]);

        $technician = User::create([
            'company_id' => $company->id,
            'name' => 'فني أحمد القحطاني',
            'email' => 'tech@nabico.sa',
            'phone' => '0504445566',
            'password' => Hash::make('password'),
            'role' => 'technician',
            'job_title' => 'فني صيانة شبكات ومضخات',
            'avatar_emoji' => '👷',
            'is_active' => true,
        ]);

        $technician2 = User::create([
            'company_id' => $company->id,
            'name' => 'م. فهد المطيري',
            'email' => 'fahad@nabico.sa',
            'phone' => '0505556677',
            'password' => Hash::make('password'),
            'role' => 'technician',
            'job_title' => 'مهندس فحص أنظمة إنذار وإطفاء',
            'avatar_emoji' => '🔧',
            'is_active' => true,
        ]);

        $clientUser = User::create([
            'company_id' => $company->id,
            'name' => 'مدارس الأندلس الأهلية (أ. خالد الحربي)',
            'email' => 'client@andalus-school.sa',
            'phone' => '0506667788',
            'password' => Hash::make('password'),
            'role' => 'client',
            'job_title' => 'مدير السلامة والأمن المدرسي',
            'avatar_emoji' => '🏫',
            'is_active' => true,
        ]);

        // 3. Create Facilities / Client Sites
        $facility1 = Facility::create([
            'company_id' => $company->id,
            'client_user_id' => null,
            'name' => 'مصنع الخزف والبلاستيك السعودي',
            'sector' => 'industrial',
            'city' => 'الدمام',
            'district' => 'المدينة الصناعية الثانية',
            'zone_type' => 'inside_city',
            'address' => 'المنطقة الصناعية الثانية، شارع 45، الدمام',
            'contact_person' => 'م. حسام التميمي',
            'contact_phone' => '0541122334',
            'contact_email' => 'safety@saudi-ceramics.com',
            'safety_license_number' => 'SCD-88392-DMM',
            'safety_license_expiry' => Carbon::now()->addMonths(8),
            'notes' => 'يحتوي على مستودعات مواد قابلة للاشتعال وشبكة مضخات ديزل 1000 GPM.',
        ]);

        $facility2 = Facility::create([
            'company_id' => $company->id,
            'client_user_id' => $clientUser->id,
            'name' => 'مجمع مدارس الأندلس الأهلية',
            'sector' => 'educational',
            'city' => 'الرياض',
            'district' => 'حي النرجس',
            'zone_type' => 'inside_city',
            'address' => 'طريق عثمان بن عفان، حي النرجس، الرياض',
            'contact_person' => 'أ. خالد الحربي',
            'contact_phone' => '0506667788',
            'contact_email' => 'client@andalus-school.sa',
            'safety_license_number' => 'SL-EDU-2025-091',
            'safety_license_expiry' => Carbon::now()->addMonths(11),
            'notes' => 'مبنى 4 أدوار، 142 طفاية حريق، شبكة إنذار معنونة Addressable.',
        ]);

        $facility3 = Facility::create([
            'company_id' => $company->id,
            'client_user_id' => null,
            'name' => 'مستودعات الغانم المركزية (طلب معاينة جديد)',
            'sector' => 'warehousing',
            'city' => 'الرياض',
            'district' => 'طريق الخرج القديم',
            'zone_type' => 'outside_city',
            'address' => 'طريق الخرج، كيلو 28، خارج النطاق العمراني',
            'contact_person' => 'أ. ناصر الغانم',
            'contact_phone' => '0559988776',
            'contact_email' => 'logistics@alghanim-storage.sa',
            'safety_license_number' => null,
            'safety_license_expiry' => null,
            'notes' => 'موقع جديد يطلب كشف هندسي لإصدار رخصة سلامة دفاع مدني.',
        ]);

        $facility4 = Facility::create([
            'company_id' => $company->id,
            'client_user_id' => null,
            'name' => 'مجمع دار الرعاية الطبي التخصصي',
            'sector' => 'medical',
            'city' => 'الرياض',
            'district' => 'حي الملز',
            'zone_type' => 'inside_city',
            'address' => 'شارع الستين، حي الملز، الرياض',
            'contact_person' => 'د. فواز العتيبي',
            'contact_phone' => '0507788990',
            'contact_email' => 'facility@care-medical.sa',
            'safety_license_number' => 'MOH-SFT-99120',
            'safety_license_expiry' => Carbon::now()->subMonths(1),
            'notes' => 'عقد منتهي ويوجد عطل متكرر في لوحة الإنذار بالدور الثالث.',
        ]);

        // 4. Create Contracts
        $contract1 = Contract::create([
            'company_id' => $company->id,
            'facility_id' => $facility1->id,
            'contract_number' => 'CNT-2026-001',
            'title' => 'عقد صيانة شاملة لأنظمة الإطفاء والإنذار - مصنع الخزف',
            'contract_type' => 'annual_comprehensive',
            'start_date' => Carbon::now()->subMonths(4),
            'end_date' => Carbon::now()->addMonths(8),
            'total_amount' => 45000.00,
            'visits_quota' => 4,
            'visits_used' => 2,
            'status' => 'active',
            'attachment_path' => 'contracts/ceramic_contract_signed.pdf',
            'notes' => 'يشمل 4 زيارات وقائية سنوية وزيارات الطوارئ غير محدودة.',
        ]);

        $contract2 = Contract::create([
            'company_id' => $company->id,
            'facility_id' => $facility2->id,
            'contract_number' => 'CNT-2026-002',
            'title' => 'عقد الصيانة الوقائية السنوية - مدارس الأندلس',
            'contract_type' => 'annual_comprehensive',
            'start_date' => Carbon::now()->subMonths(2),
            'end_date' => Carbon::now()->addMonths(10),
            'total_amount' => 28000.00,
            'visits_quota' => 4,
            'visits_used' => 1,
            'status' => 'active',
            'attachment_path' => 'contracts/andalus_school_contract.pdf',
            'notes' => 'زيارات ربع سنوية دورية واختبار مضخات الحريق وتعبئة الطفايات.',
        ]);

        $contract4 = Contract::create([
            'company_id' => $company->id,
            'facility_id' => $facility4->id,
            'contract_number' => 'CNT-2025-089',
            'title' => 'عقد صيانة مجمع دار الرعاية الطبي (منتهي)',
            'contract_type' => 'preventive_maintenance',
            'start_date' => Carbon::now()->subYear(),
            'end_date' => Carbon::now()->subDays(15),
            'total_amount' => 32000.00,
            'visits_quota' => 4,
            'visits_used' => 4,
            'status' => 'expired',
            'attachment_path' => 'contracts/care_medical_contract_old.pdf',
            'notes' => 'انتهى العقد ويحتاج تجديد.',
        ]);

        // 5. Create Maintenance Requests
        $req1 = MaintenanceRequest::create([
            'company_id' => $company->id,
            'facility_id' => $facility1->id,
            'requester_id' => $manager->id,
            'request_number' => 'REQ-2026-101',
            'type' => 'emergency',
            'priority' => 'critical',
            'system_type' => 'fire_pumps',
            'title' => 'تسريب مياه حاد وانخفاض ضغط مضخة الديزل الرئيسية',
            'description' => 'لاحظ مشرف الموقع انخفاض ضغط خط الحريق وتسريب حول محبس عدم الرجوع لمضخة الديزل الرئيسية.',
            'status' => 'in_progress',
            'preferred_date' => Carbon::now(),
        ]);

        $req2 = MaintenanceRequest::create([
            'company_id' => $company->id,
            'facility_id' => $facility3->id,
            'requester_id' => $clientUser->id,
            'request_number' => 'REQ-2026-102',
            'type' => 'quote_request',
            'priority' => 'medium',
            'system_type' => 'all_systems',
            'title' => 'طلب معاينة وكشف تمهيدي لاستخراج شهادة سلامة',
            'description' => 'مستودع جديد على طريق الخرج بمساحة 8,000 م2 يرغب في كشف مبدئي وعرض سعر عقد صيانة سنوي.',
            'status' => 'scheduled',
            'preferred_date' => Carbon::now()->addDay(),
        ]);

        // 6. Create Visits
        // Visit 1 (In Progress, has unpaid parts)
        $visit1 = Visit::create([
            'company_id' => $company->id,
            'facility_id' => $facility1->id,
            'contract_id' => $contract1->id,
            'maintenance_request_id' => $req1->id,
            'assigned_engineer_id' => $technician->id,
            'assigned_supervisor_id' => $supervisor->id,
            'visit_number' => 'VST-991',
            'visit_type' => 'emergency',
            'scheduled_at' => Carbon::now()->subHours(2),
            'location_zone' => 'inside_city',
            'visit_fee' => 0.00,
            'fee_status' => 'covered_by_contract',
            'purpose' => 'فحص ضغط مضخة الحريق الديزل واختبار التسريب بالمحبس الرئيسي',
            'status' => 'in_progress',
            'has_unpaid_parts' => true,
            'unpaid_parts_amount' => 4800.00,
            'unpaid_parts_notes' => '⚠️ توجد ملاحظة فنية: تسريب في محبس عدم الرجوع (Check Valve 4") ولم يتم سداد قيمة القطعة من قبل العميل.',
            'notes' => 'تم الانتقال للموقع وبدء عملية فحص غطاء المضخة وضغط الشبكة.',
        ]);

        // Visit 2 (Scheduled today, covered by contract)
        $visit2 = Visit::create([
            'company_id' => $company->id,
            'facility_id' => $facility2->id,
            'contract_id' => $contract2->id,
            'maintenance_request_id' => null,
            'assigned_engineer_id' => $technician2->id,
            'assigned_supervisor_id' => $supervisor->id,
            'visit_number' => 'VST-992',
            'visit_type' => 'quarterly_inspection',
            'scheduled_at' => Carbon::now()->addHours(3),
            'location_zone' => 'inside_city',
            'visit_fee' => 0.00,
            'fee_status' => 'covered_by_contract',
            'purpose' => 'فحص 142 طفاية حريق وفحص كواشف الدخان في الفصول والمختبرات (فحص دوري Q3)',
            'status' => 'scheduled',
            'has_unpaid_parts' => false,
            'unpaid_parts_amount' => 0.00,
            'notes' => 'تم إرسال تذكير تلقائي عبر SMS للعميل قبل 48 ساعة.',
        ]);

        // Visit 3 (Pre-contract outside city zone pricing 650 SAR)
        $visit3 = Visit::create([
            'company_id' => $company->id,
            'facility_id' => $facility3->id,
            'contract_id' => null,
            'maintenance_request_id' => $req2->id,
            'assigned_engineer_id' => $technician2->id,
            'assigned_supervisor_id' => $supervisor->id,
            'visit_number' => 'VST-995',
            'visit_type' => 'pre_contract_audit',
            'scheduled_at' => Carbon::now()->addDay()->setHour(9)->setMinute(0),
            'location_zone' => 'outside_city',
            'visit_fee' => 650.00,
            'fee_status' => 'paid',
            'purpose' => 'معاينة الموقع وتقدير كوتيشن أنظمة الإطفاء ورخصة سلامة للدفاع المدني',
            'status' => 'scheduled',
            'has_unpaid_parts' => false,
            'unpaid_parts_amount' => 0.00,
            'notes' => 'موقع خارج نطاق المدينة، تم استلام رسوم الزيارة 650 ر.س مسبقاً.',
        ]);

        // Visit 4 (Completed with unpaid parts warning)
        $visit4 = Visit::create([
            'company_id' => $company->id,
            'facility_id' => $facility4->id,
            'contract_id' => null,
            'maintenance_request_id' => null,
            'assigned_engineer_id' => $technician->id,
            'assigned_supervisor_id' => $supervisor->id,
            'visit_number' => 'VST-989',
            'visit_type' => 'emergency',
            'scheduled_at' => Carbon::now()->subDay()->setHour(11)->setMinute(0),
            'location_zone' => 'inside_city',
            'visit_fee' => 350.00,
            'fee_status' => 'unpaid',
            'purpose' => 'إصلاح عطل متكرر في لوحة الإنذار بالدور الثالث وتبديل بطاريات الطوارئ',
            'status' => 'completed',
            'has_unpaid_parts' => true,
            'unpaid_parts_amount' => 2300.00,
            'unpaid_parts_notes' => '⚠️ تم تركيب كواشف جديدة ولوحة إمداد طاقة وبطاريات ولم يتم سداد قيمة قطع الغيار حتى الآن.',
            'notes' => 'المنشأة غير متعاقدة وتحتاج تسوية مالية قبل اعتماد شهادة الفحص.',
        ]);

        // 7. Visit Images
        VisitImage::create([
            'visit_id' => $visit1->id,
            'facility_id' => $facility1->id,
            'uploaded_by_user_id' => $technician->id,
            'image_path' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?w=800&auto=format&fit=crop&q=60',
            'caption' => 'صورة تسريب محبس مضخة الديزل قبل فك الوصلات',
            'stage' => 'defect_evidence',
        ]);

        VisitImage::create([
            'visit_id' => $visit1->id,
            'facility_id' => $facility1->id,
            'uploaded_by_user_id' => $technician->id,
            'image_path' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=800&auto=format&fit=crop&q=60',
            'caption' => 'فحص ضغط خط الطرد وعداد البار',
            'stage' => 'during_inspection',
        ]);

        VisitImage::create([
            'visit_id' => $visit4->id,
            'facility_id' => $facility4->id,
            'uploaded_by_user_id' => $technician->id,
            'image_path' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=800&auto=format&fit=crop&q=60',
            'caption' => 'لوحة الإنذار الرئيسية بالدور الثالث بعد استبدال بطاريات 12V',
            'stage' => 'after_work',
        ]);

        // 8. Visit Items / Spare Parts
        VisitItem::create([
            'visit_id' => $visit1->id,
            'item_name' => 'محبس عدم رجوع Check Valve 4 إنش معتمد UL/FM',
            'item_category' => 'pump_part',
            'quantity' => 1,
            'unit_price' => 3800.00,
            'total_price' => 3800.00,
            'condition_status' => 'replaced',
            'payment_status' => 'unpaid',
            'notes' => 'تم استبدال المحبس القديم التالف، مطلوب سداد المبلغ من العميل.',
        ]);

        VisitItem::create([
            'visit_id' => $visit1->id,
            'item_name' => 'جلب مانع تسريب وحشوة ميكانيكية مضخة ديزل',
            'item_category' => 'pump_part',
            'quantity' => 2,
            'unit_price' => 500.00,
            'total_price' => 1000.00,
            'condition_status' => 'replaced',
            'payment_status' => 'unpaid',
            'notes' => 'تم التركيب لمنع تنقيط المياه وضمان استقرار الضغط عند 10 بار.',
        ]);

        VisitItem::create([
            'visit_id' => $visit4->id,
            'item_name' => 'بطاريات شحن لوحة إنذار الحريق 12V 18Ah (زوج)',
            'item_category' => 'alarm_part',
            'quantity' => 2,
            'unit_price' => 650.00,
            'total_price' => 1300.00,
            'condition_status' => 'replaced',
            'payment_status' => 'unpaid',
            'notes' => 'البطاريات السابقة كانت مفرغة ومعدومة الشحن.',
        ]);

        VisitItem::create([
            'visit_id' => $visit4->id,
            'item_name' => 'كواشف دخان بصرية Addressable Smoke Detectors',
            'item_category' => 'alarm_part',
            'quantity' => 4,
            'unit_price' => 250.00,
            'total_price' => 1000.00,
            'condition_status' => 'replaced',
            'payment_status' => 'unpaid',
            'notes' => 'تم استبدال 4 كواشف تالفة بالدور الثالث.',
        ]);

        // 9. Visit Reports
        VisitReport::create([
            'visit_id' => $visit4->id,
            'engineer_id' => $technician->id,
            'report_number' => 'REP-2026-989',
            'summary' => 'تم فحص لوحة إنذار الحريق بالدور الثالث واستبدال البطاريات والكواشف التالفة، والنظام يعمل الآن بكفاءة.',
            'overall_status' => 'passed_with_notes',
            'checklist_results' => [
                'fire_alarm_panel' => 'pass',
                'smoke_detectors' => 'pass',
                'emergency_batteries' => 'pass',
                'sounders_strobes' => 'pass',
                'pumps_pressure' => 'warning',
                'fire_extinguishers' => 'pass',
            ],
            'recommendations' => 'يوصى بتجديد العقد السنوي الشامل وإجراء صيانة دورية لمضخات الطابق السفلي وسداد قيمة البطاريات.',
            'engineer_notes' => 'تم اختبار زر الإنذار اليدوي ووصلت الإشارة للوحة الرئيسية في 1.2 ثانية.',
            'client_signature_name' => 'د. فواز العتيبي (مسؤول الموقع)',
            'pdf_path' => 'reports/rep_989_medical_signed.pdf',
            'status' => 'approved',
            'approved_by_user_id' => $manager->id,
            'approved_at' => Carbon::now()->subDay()->setHour(14)->setMinute(30),
        ]);

        // 10. Internal Requests
        InternalRequest::create([
            'company_id' => $company->id,
            'requester_id' => $technician->id,
            'department_from' => 'قسم الصيانة الميدانية',
            'department_to' => 'إدارة المستودعات وقطع الغيار',
            'request_type' => 'spare_parts_release',
            'title' => 'طلب صرف محبس عدم رجوع 4 إنش UL/FM لزيارة مصنع الخزف',
            'description' => 'نظراً لوجود تسريب حرج في مضخة الديزل، نرجو الموافقة على صرف المحبس فوراً وتأمين سيارة الدعم.',
            'priority' => 'urgent',
            'status' => 'approved',
            'reviewed_by_id' => $manager->id,
            'review_notes' => 'تمت الموافقة والصرف من مستودع الرياض المركزي تحت إذن صرف رقم #981.',
        ]);

        InternalRequest::create([
            'company_id' => $company->id,
            'requester_id' => $technician2->id,
            'department_from' => 'قسم الفحص والمطابقة',
            'department_to' => 'إدارة الحركة والأسطول',
            'request_type' => 'site_vehicle_dispatch',
            'title' => 'طلب سيارة فحص ميداني وسلالم هيدروليكية لمستودعات الغانم (طريق الخرج)',
            'description' => 'الموقع خارج نطاق المدينة ويتطلب سلالم تلسكوبية لفحص كواشف الأسقف المرتفعة 12 متراً.',
            'priority' => 'high',
            'status' => 'pending',
            'reviewed_by_id' => null,
            'review_notes' => null,
        ]);

        // 11. System Notifications & 48-Hour Reminders
        SystemNotification::create([
            'company_id' => $company->id,
            'user_id' => $admin->id,
            'type' => 'unpaid_parts_alert',
            'title' => '⚠️ تنبيه تحصيل: قطع غيار غير مسددة بمبلغ 4,800 ر.س',
            'message' => 'تم تسجيل تركيب محبس عدم رجوع في زيارة مصنع الخزف (#VST-991) بدون سداد من العميل.',
            'target_url' => '/dashboard/visits',
            'is_read' => false,
            'priority' => 'warning',
        ]);

        SystemNotification::create([
            'company_id' => $company->id,
            'user_id' => $clientUser->id,
            'type' => 'visit_reminder_48h',
            'title' => '🔔 تذكير موعد زيارة فحص دوري مجدولة',
            'message' => 'عزيزي العميل، نود تذكيركم بموعد زيارة الفحص الدوري لشبكات الإطفاء والإنذار بمدارس الأندلس اليوم.',
            'target_url' => '/dashboard/visits',
            'is_read' => false,
            'priority' => 'normal',
        ]);

        SystemNotification::create([
            'company_id' => $company->id,
            'user_id' => $manager->id,
            'type' => 'new_maintenance_request',
            'title' => '📥 طلب معاينة جديد لمستودعات الغانم (خارج المدينة)',
            'message' => 'تم استلام طلب معاينة تمهيدي جديد برسوم 650 ر.س، تم جدولة المهندس المشرف.',
            'target_url' => '/dashboard/visits',
            'is_read' => true,
            'priority' => 'normal',
        ]);
    }
}
