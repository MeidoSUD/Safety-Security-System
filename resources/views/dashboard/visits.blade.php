@extends('layouts.dashboard')

@section('title', 'الزيارات وتسعير النطاق وقطع الغيار | نبيكو العربية ERP')
@section('page_title', 'جدول الزيارات الميدانية، تسعير النطاق الجغرافي، وتنبيهات قطع الغيار')

@section('content')

    <!-- 1. TOP CONTROLS & AUTOMATED REMINDER TOGGLE -->
    <div class="grid lg:grid-cols-12 gap-6 mb-6">
        
        <!-- Automated Visit Reminder Toggle Box (Requirement) -->
        <div class="lg:col-span-6 bg-white rounded-2xl border border-slate-200 p-5 shadow-sm flex items-center justify-between gap-4">
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <span class="text-base">🔔</span>
                    <b class="text-sm text-slate-900">نظام الإشعارات التذكيرية التلقائية للزيارات</b>
                </div>
                <p class="text-xs text-slate-500">
                    إرسال رسائل SMS وتنبيهات بريدية تلقائية للعميل وفريق الفحص قبل موعد الزيارة بـ 48 ساعة.
                </p>
            </div>

            <!-- Toggle Switch -->
            <label class="relative inline-flex items-center cursor-pointer shrink-0">
                <input type="checkbox" id="reminder-toggle" checked onchange="toggleReminder(this)" class="sr-only peer">
                <div class="w-12 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                <span class="mr-2 text-xs font-bold text-slate-700" id="reminder-status-text">مفعلة ✓</span>
            </label>
        </div>

        <!-- Pre-Contract / Non-Contractual Pricing Summary Box (Requirement) -->
        <div class="lg:col-span-6 bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-2">
            <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                <b class="text-xs text-slate-900 flex items-center gap-1.5">
                    <span>📍 تسعير زيارات المعاينة لغير المتعاقدين (Zone Pricing):</span>
                </b>
                <button onclick="alert('تم فتح إعدادات تعديل تسعيرة الزيارات')" class="text-[11px] text-blue-700 font-bold hover:underline">
                    تعديل التسعيرة ⚙️
                </button>
            </div>
            
            <div class="grid sm:grid-cols-2 gap-2 text-xs">
                <div class="p-2.5 bg-slate-50 rounded-lg border border-slate-200 flex justify-between items-center">
                    <div>
                        <b class="text-slate-800 block text-[11px]">داخل نطاق المدينة</b>
                        <span class="text-[10px] text-slate-500">الرياض، جدة، الدمام</span>
                    </div>
                    <span class="font-mono font-black text-slate-900 bg-white px-2 py-1 rounded border border-slate-200">350 ر.س</span>
                </div>

                <div class="p-2.5 bg-slate-50 rounded-lg border border-slate-200 flex justify-between items-center">
                    <div>
                        <b class="text-slate-800 block text-[11px]">خارج نطاق المدينة والمناطق البعيدة</b>
                        <span class="text-[10px] text-slate-500">المحافظات والمدن الصناعية الخارجية</span>
                    </div>
                    <span class="font-mono font-black text-slate-900 bg-white px-2 py-1 rounded border border-slate-200">650 ر.س</span>
                </div>
            </div>
        </div>

    </div>

    <!-- 2. UNPAID SPARE PARTS WARNING BANNER (Core Requirement) -->
    <div class="p-4 rounded-2xl border border-amber-300 bg-amber-50/70 shadow-sm mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-start sm:items-center gap-3">
            <span class="text-2xl">⚠️</span>
            <div>
                <b class="text-amber-950 text-xs sm:text-sm block font-extrabold">
                    تنبيه نظام: توجد منشآت تم تسجيل ملاحظات تشغيلية عليها ولم يتم سداد قيمة قطع الغيار المطلوبة!
                </b>
                <p class="text-[11px] text-amber-900 mt-0.5">
                    يتم تمييز المنشآت بشارة تحذير صفراء/حمراء لتنبيه إدارة التحصيل والمهندس المشرف قبل إصدار شهادة السلامة النهائية.
                </p>
            </div>
        </div>
        <button onclick="filterUnpaidParts()" class="px-3.5 py-1.5 bg-amber-800 hover:bg-amber-900 text-white rounded-lg text-xs font-bold shrink-0">
            تصفية الأنظمة المتأخرة السداد (2)
        </button>
    </div>

    <!-- 3. VISITS LIST WITH REPORT ATTACHMENTS & UNPAID WARNING FLAGS -->
    <div class="space-y-4">
        
        @foreach($visits as $v)
            <div class="bg-white rounded-2xl border {{ $v['has_unpaid_parts'] ? 'border-amber-300 ring-2 ring-amber-100' : 'border-slate-200' }} p-6 shadow-sm space-y-4 visit-card" data-unpaid="{{ $v['has_unpaid_parts'] ? 'yes' : 'no' }}">
                
                <!-- Visit Header -->
                <div class="flex flex-wrap items-start justify-between gap-4 border-b border-slate-100 pb-4">
                    
                    <div class="space-y-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="font-mono text-xs font-bold text-slate-700 bg-slate-100 px-2 py-0.5 rounded">#{{ $v['id'] }}</span>
                            <h3 class="text-base font-bold text-slate-900">{{ $v['facility'] }}</h3>
                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-200">{{ $v['type'] }}</span>
                            
                            @if($v['status'] == 'in_progress')
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-100 text-amber-900 border border-amber-300 animate-pulse">
                                    {{ $v['status_label'] }}
                                </span>
                            @elseif($v['status'] == 'scheduled')
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-100 text-blue-900 border border-blue-200">
                                    {{ $v['status_label'] }}
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-900 border border-emerald-300">
                                    {{ $v['status_label'] }}
                                </span>
                            @endif
                        </div>

                        <div class="text-xs text-slate-500 flex flex-wrap items-center gap-3 mt-1">
                            <span>حالة التعاقد: <b class="text-slate-800">{{ $v['contract_status'] }}</b></span>
                            <span>•</span>
                            <span>النطاق الجغرافي: <b>{{ $v['location_zone'] }}</b></span>
                            <span>•</span>
                            <span>رسوم الزيارة: <b class="font-mono font-bold text-slate-900">{{ $v['visit_fee'] }}</b></span>
                        </div>
                    </div>

                    <!-- Unpaid Spare Parts Warning Badge (Requirement) -->
                    @if($v['has_unpaid_parts'])
                        <div class="p-3 bg-red-50 border border-red-200 rounded-xl text-xs text-red-900 max-w-md space-y-1">
                            <div class="flex items-center gap-1.5 font-bold text-red-700">
                                <span>🚨</span>
                                <span>انظمة بها ملاحظات ولم يتم سداد قيمة قطع الغيار</span>
                            </div>
                            <div class="text-[11px] text-red-800">{{ $v['unpaid_parts_notes'] }}</div>
                            <div class="text-[11px] font-mono font-bold text-red-900">المبلغ المعلق: {{ $v['unpaid_parts_amount'] }}</div>
                        </div>
                    @endif

                </div>

                <!-- Visit Details & Report Attachment Section (Requirement) -->
                <div class="grid lg:grid-cols-12 gap-4 items-center">
                    
                    <div class="lg:col-span-7 text-xs text-slate-600 space-y-1.5 bg-slate-50 p-4 rounded-xl border border-slate-200">
                        <div><b>المهندس الفاحص:</b> {{ $v['engineer'] }} • <b>المشرف الميداني:</b> {{ $v['supervisor'] }}</div>
                        <div><b>الموعد والوقت:</b> <span class="font-mono font-bold text-slate-800">{{ $v['time'] }}</span> • <b>المدينة:</b> {{ $v['city'] }}</div>
                        <div class="text-slate-700 pt-1 border-t border-slate-200 mt-1"><b>الغرض من الفحص:</b> {{ $v['purpose'] }}</div>
                    </div>

                    <!-- Visit Report Attachment Slot (Requirement) -->
                    <div class="lg:col-span-5 bg-white p-4 rounded-xl border border-slate-200 space-y-2">
                        <div class="flex items-center justify-between text-xs font-bold text-slate-900">
                            <span>📄 مرفق تقرير الزيارة الفني:</span>
                            <span class="text-[10px] text-slate-400">PDF / صور</span>
                        </div>

                        @if($v['report_attachment'])
                            <div class="p-2.5 bg-slate-50 rounded-lg border border-slate-200 flex items-center justify-between text-xs">
                                <div>
                                    <b class="text-slate-900 block text-[11px] truncate max-w-[200px]">{{ $v['report_attachment']['name'] }}</b>
                                    <span class="text-[10px] text-slate-500">{{ $v['report_attachment']['size'] }} • {{ $v['report_attachment']['status'] }}</span>
                                </div>
                                <button onclick="alert('تم فتح تقرير الزيارة: {{ $v['report_attachment']['name'] }}')" class="px-2.5 py-1 bg-slate-900 hover:bg-slate-800 text-white rounded font-bold text-[11px]">
                                    معاينة ⬇
                                </button>
                            </div>
                        @else
                            <div class="p-2.5 bg-slate-50 rounded-lg border border-dashed border-slate-300 text-center text-xs text-slate-500">
                                <span>لم يتم إرفاق التقرير بعد (الزيارة قادمة)</span>
                            </div>
                        @endif
                    </div>

                </div>

            </div>
        @endforeach

    </div>

    <script>
        function toggleReminder(el) {
            const txt = document.getElementById('reminder-status-text');
            if (el.checked) {
                txt.innerText = 'مفعلة ✓';
                txt.className = 'mr-2 text-xs font-bold text-slate-700';
                alert('تم تفعيل نظام الإشعارات التذكيرية التلقائية عبر SMS والبريد.');
            } else {
                txt.innerText = 'معطلة ✕';
                txt.className = 'mr-2 text-xs font-bold text-red-600';
                alert('تم إيقاف الإشعارات التذكيرية التلقائية.');
            }
        }

        function filterUnpaidParts() {
            document.querySelectorAll('.visit-card').forEach(card => {
                if (card.getAttribute('data-unpaid') === 'yes') {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>

@endsection
