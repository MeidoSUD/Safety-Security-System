@extends('layouts.dashboard')

@section('title', 'إدارة نماذج وتقارير الفحص | نبيكو العربية ERP')
@section('page_title', 'إدارة وتخصيص نماذج الفحص الميداني والتقارير الفنية المعتمدة')

@section('content')

    <!-- Top Workspace Selector -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                <span>📝 منظومة التقارير الفنية المعتمدة (Technical Reports System)</span>
                <span class="text-xs px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-semibold">تحكم Admin كامل</span>
            </h2>
            <p class="text-xs text-slate-500 mt-0.5">
                تتيح للفنيين تعبئة التقارير الميدانية فورياً، مع صلاحيات كاملة للإدارة العليا لتعديل وتخصيص نماذج الفحص وإضافة بنود جديدة.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <button onclick="openTemplateModal()" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-lg text-xs font-bold transition-colors flex items-center gap-1.5">
                <span>+</span>
                <span>إنشاء / تعديل نموذج فحص جديد ⚙️</span>
            </button>
            <button onclick="openTechReportModal()" class="px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white rounded-lg text-xs font-bold transition-colors flex items-center gap-1.5">
                <span>📋</span>
                <span>بوابة الفني: تعبئة تقرير فحص ميداني</span>
            </button>
        </div>
    </div>

    <!-- 1. ADMIN/DOMAIN SUPER USER TEMPLATE MANAGEMENT (Requirement) -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm mb-6 space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div>
                <b class="text-sm text-slate-900">1. نماذج الفحص المعتمدة والقابلة للتخصيص (Admin Report Templates Controls)</b>
                <p class="text-xs text-slate-500">يمكن للإدارة تعديل بنود الفحص، إضافة حقول جديدة، أو تعطيل النماذج.</p>
            </div>
            <span class="text-xs font-mono font-bold text-slate-700 bg-slate-100 px-2.5 py-1 rounded">4 نماذج نشطة</span>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            @foreach($templates as $tpl)
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white hover:border-slate-300 transition-all space-y-3">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <span class="font-mono text-xs font-bold text-slate-500 bg-slate-200 px-2 py-0.5 rounded">#{{ $tpl['id'] }}</span>
                            <b class="text-xs text-slate-900 block mt-1.5">{{ $tpl['name'] }}</b>
                        </div>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 shrink-0">نشط ✓</span>
                    </div>

                    <div class="text-xs text-slate-600 flex flex-wrap gap-3 pt-2 border-t border-slate-200/80">
                        <span>القسم: <b>{{ $tpl['category'] }}</b></span>
                        <span>•</span>
                        <span>عدد الحقول والبنود: <b class="font-mono">{{ $tpl['fields_count'] }} بند</b></span>
                        <span>•</span>
                        <span>آخر تحديث: {{ $tpl['last_updated'] }}</span>
                    </div>

                    <div class="flex items-center justify-between pt-1">
                        <span class="text-[11px] text-slate-400">بواسطة: {{ $tpl['updated_by'] }}</span>
                        <div class="flex gap-2">
                            <button onclick="alert('تم فتح نافذة تحرير بنود النموذج #{{ $tpl['id'] }}')" class="px-2.5 py-1 bg-white hover:bg-slate-100 text-slate-800 border border-slate-300 rounded font-bold text-[11px]">
                                تعديل الحقول ✏️
                            </button>
                            <button onclick="alert('تم نسخ النموذج')" class="px-2.5 py-1 bg-white hover:bg-slate-100 text-slate-800 border border-slate-300 rounded font-bold text-[11px]">
                                نسخ 📋
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- 2. ISSUED REPORTS & SALAMAH LICENSES ARCHIVE -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div>
                <b class="text-sm text-slate-900">2. سجل التقارير الفنية الصادرة ورخص الدفاع المدني</b>
                <p class="text-xs text-slate-500">التقارير المكتملة والمرفوعة على منصة سلامة.</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-600 border-b border-slate-200 font-bold">
                        <th class="p-3">رقم التقرير / الشهادة</th>
                        <th class="p-3">المنشأة المستفيدة</th>
                        <th class="p-3">النموذج المستخدم</th>
                        <th class="p-3">تاريخ الإصدار</th>
                        <th class="p-3">المهندس الفاحص</th>
                        <th class="p-3">الحالة</th>
                        <th class="p-3 text-center">المرفق</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($issuedReports as $r)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="p-3 font-mono font-bold text-slate-900">#{{ $r['number'] }}</td>
                            <td class="p-3 font-bold text-slate-900">{{ $r['facility'] }}</td>
                            <td class="p-3 text-slate-600">{{ $r['template_used'] }}</td>
                            <td class="p-3 font-mono text-slate-500">{{ $r['date'] }}</td>
                            <td class="p-3 text-slate-700">{{ $r['engineer'] }}</td>
                            <td class="p-3">
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                    {{ $r['status'] }} ✓
                                </span>
                            </td>
                            <td class="p-3 text-center">
                                <button onclick="alert('تم تنزيل المرفق: {{ $r['attachment_file'] }}')" class="px-3 py-1 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold rounded-lg text-xs">
                                    تحميل PDF 📄
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL: FIELD TECHNICIAN REPORT SUBMISSION PORTAL (Requirement) -->
    <dialog id="techReportModal" class="rounded-2xl p-0 bg-white border border-slate-200 shadow-2xl max-w-xl w-full text-slate-800 m-auto overflow-hidden">
        <div class="p-6 space-y-4">
            <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                <b class="text-base text-slate-900 flex items-center gap-1.5">
                    <span>👷</span>
                    <span>بوابة الفني: تعبئة تقرير الفحص الميداني المباشر</span>
                </b>
                <button onclick="closeModal('techReportModal')" class="text-slate-400 hover:text-slate-900 p-1">✕</button>
            </div>

            <form onsubmit="handleTechReportSubmit(event)" class="space-y-3 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">اختر الزيارة الميدانية المكلف بها *</label>
                    <select class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-900 font-bold">
                        <option>#VST-991: مصنع الخزف والبلاستيك السعودي (الدمام)</option>
                        <option>#VST-992: مجمع مدارس الأندلس الأهلية (الرياض)</option>
                        <option>#VST-995: مستودعات الغانم المركزية (طريق الخرج)</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">النموذج المعتمد للتعبئة *</label>
                    <select class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-900">
                        <option>نموذج الفحص الشامل لمضخات الحريق وشبكات الرش الآلي</option>
                        <option>نموذج فحص واختبار لوحات الإنذار وكواشف الدخان</option>
                        <option>استمارة فحص أنظمة الإطفاء الغازية (FM200 / CO2)</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">قراءة ضغط الشبكة الرئيسي (PSI) *</label>
                        <input type="text" required placeholder="مثال: 140 PSI" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-900 font-mono">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">حالة مضخة الديزل التلقائية *</label>
                        <select class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-900">
                            <option>سليمة وتعمل تلقائياً (Pass)</option>
                            <option>يوجد تسريب طفيف بحاجة لقطع غيار</option>
                            <option>عطل في بطاريات التشغيل</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">هل توجد قطع غيار مطلوبة للإصلاح؟</label>
                    <input type="text" placeholder="اذكر اسم القطعة وعددها (مثال: محبس عدم رجوع 2.5 بوصة + فلاتر)" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-900">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">إرفاق صور المعاينة والفحص الميداني</label>
                    <input type="file" multiple class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2 text-xs text-slate-600">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">ملاحظات الفني التفصيلية:</label>
                    <textarea rows="2" placeholder="تم فحص جميع الخطوط والمحابس..." class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2 text-xs text-slate-900"></textarea>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3 bg-blue-700 hover:bg-blue-800 text-white rounded-lg font-bold text-xs shadow-sm">
                        إرسال التقرير الفني واعتماده في النظام ✓
                    </button>
                </div>
            </form>
        </div>
    </dialog>

    <script>
        function openTechReportModal() {
            document.getElementById('techReportModal').showModal();
        }

        function openTemplateModal() {
            alert('تم فتح محرر نماذج التقارير بصلاحيات الأدمن الكاملة لإضافة أو تعديل الحقول.');
        }

        function closeModal(id) {
            document.getElementById(id).close();
        }

        function handleTechReportSubmit(e) {
            e.preventDefault();
            closeModal('techReportModal');
            alert('تم إرسال تقرير الفحص الميداني بنجاح وربطه بالزيارة وإشعار الإدارة الهندسية.');
        }
    </script>

@endsection
