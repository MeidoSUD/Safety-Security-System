@extends('layouts.dashboard')

@section('title', 'الزيارات وتسعير النطاق وقطع الغيار | نبيكو العربية ERP')
@section('page_title', 'جدول الزيارات الميدانية، تسعير النطاق الجغرافي، وتنبيهات قطع الغيار')

@section('content')

    <!-- 1. TOP CONTROLS & AUTOMATED REMINDER TOGGLE -->
    <div class="grid lg:grid-cols-12 gap-6 mb-6">
        
        <!-- Automated Visit Reminder Toggle Box -->
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

        <!-- Pre-Contract / Non-Contractual Pricing Summary Box -->
        <div class="lg:col-span-6 bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-2">
            <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                <b class="text-xs text-slate-900 flex items-center gap-1.5">
                    <span>📍 تسعير زيارات المعاينة لغير المتعاقدين (Zone Pricing):</span>
                </b>
                <a href="{{ route('dashboard.saas_settings') }}" class="text-[11px] text-blue-700 font-bold hover:underline">
                    تعديل التسعيرة ⚙️
                </a>
            </div>
            
            <div class="grid sm:grid-cols-2 gap-2 text-xs">
                <div class="p-2.5 bg-slate-50 rounded-lg border border-slate-200 flex justify-between items-center">
                    <div>
                        <b class="text-slate-800 block text-[11px]">داخل نطاق المدينة</b>
                        <span class="text-[10px] text-slate-500">الرياض، جدة، الدمام</span>
                    </div>
                    <span class="font-mono font-black text-slate-900 bg-white px-2 py-1 rounded border border-slate-200">{{ $company->zone_rate_inside ?? 350 }} ر.س</span>
                </div>

                <div class="p-2.5 bg-slate-50 rounded-lg border border-slate-200 flex justify-between items-center">
                    <div>
                        <b class="text-slate-800 block text-[11px]">خارج نطاق المدينة والمناطق البعيدة</b>
                        <span class="text-[10px] text-slate-500">المحافظات والمدن الصناعية الخارجية</span>
                    </div>
                    <span class="font-mono font-black text-slate-900 bg-white px-2 py-1 rounded border border-slate-200">{{ $company->zone_rate_outside ?? 650 }} ر.س</span>
                </div>
            </div>
        </div>

    </div>

    <!-- 2. UNPAID SPARE PARTS WARNING BANNER -->
    @php
        $unpaidCount = $visits->where('has_unpaid_parts', true)->count();
    @endphp
    @if($unpaidCount > 0)
        <div class="p-4 rounded-2xl border border-amber-300 bg-amber-50/70 shadow-sm mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-start sm:items-center gap-3">
                <span class="text-2xl">⚠️</span>
                <div>
                    <b class="text-amber-950 text-xs sm:text-sm block font-extrabold">
                        تنبيه نظام: توجد منشآت تم تسجيل ملاحظات تشغيلية عليها ولم يتم سداد قيمة قطع الغيار المطلوبة!
                    </b>
                    <p class="text-[11px] text-amber-900 mt-0.5">
                        يتم تمييز المنشآت بشارة تحذير صفراء لتنبيه إدارة التحصيل والمهندس المشرف قبل اعتماد شهادة السلامة النهائية.
                    </p>
                </div>
            </div>
            <button onclick="filterUnpaidParts()" class="px-3.5 py-1.5 bg-amber-800 hover:bg-amber-900 text-white rounded-lg text-xs font-bold shrink-0">
                تصفية الأنظمة المتأخرة السداد ({{ $unpaidCount }})
            </button>
        </div>
    @endif

    <!-- 3. ACTIONS BAR & SCHEDULE MODAL TRIGGER -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <div class="flex flex-wrap items-center gap-2 text-xs font-bold">
            <a href="{{ route('dashboard.visits') }}" class="px-3 py-1.5 rounded-lg {{ !request('status') && !request('unpaid_only') ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                الكل ({{ $visits->count() }})
            </a>
            <a href="{{ route('dashboard.visits', ['status' => 'scheduled']) }}" class="px-3 py-1.5 rounded-lg {{ request('status') === 'scheduled' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                مجدولة ({{ \App\Models\Visit::where('status', 'scheduled')->count() }})
            </a>
            <a href="{{ route('dashboard.visits', ['status' => 'in_progress']) }}" class="px-3 py-1.5 rounded-lg {{ request('status') === 'in_progress' ? 'bg-amber-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                قيد التنفيذ الآن ({{ \App\Models\Visit::where('status', 'in_progress')->count() }})
            </a>
            <a href="{{ route('dashboard.visits', ['status' => 'completed']) }}" class="px-3 py-1.5 rounded-lg {{ request('status') === 'completed' ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                مكتملة ({{ \App\Models\Visit::where('status', 'completed')->count() }})
            </a>
            <a href="{{ route('dashboard.visits', ['unpaid_only' => 1]) }}" class="px-3 py-1.5 rounded-lg {{ request('unpaid_only') ? 'bg-red-600 text-white' : 'bg-red-50 text-red-700 hover:bg-red-100 border border-red-200' }}">
                ⚠️ قطع غير مسددة ({{ $unpaidCount }})
            </a>
        </div>

        <button onclick="document.getElementById('schedule-visit-modal').showModal()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-lg shadow-blue-500/20 flex items-center gap-2">
            <span>➕</span>
            <span>جدولة زيارة ميدانية جديدة</span>
        </button>
    </div>

    <!-- 4. VISITS LIST WITH REPORT ATTACHMENTS & UNPAID WARNING FLAGS -->
    <div class="space-y-4">
        
        @forelse($visits as $v)
            <div class="bg-white rounded-2xl border {{ $v->has_unpaid_parts ? 'border-amber-300 ring-2 ring-amber-100' : 'border-slate-200' }} p-6 shadow-sm space-y-4 visit-card" data-unpaid="{{ $v->has_unpaid_parts ? 'yes' : 'no' }}">
                
                <!-- Visit Header -->
                <div class="flex flex-wrap items-start justify-between gap-4 border-b border-slate-100 pb-4">
                    
                    <div class="space-y-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="font-mono text-xs font-bold text-slate-700 bg-slate-100 px-2 py-0.5 rounded">#{{ $v->visit_number }}</span>
                            <h3 class="text-base font-bold text-slate-900">{{ $v->facility->name ?? 'موقع منشأة' }}</h3>
                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-200">{{ $v->type_arabic }}</span>
                            
                            @if($v->status === 'in_progress')
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-100 text-amber-900 border border-amber-300 animate-pulse">
                                    قيد التنفيذ الآن
                                </span>
                            @elseif($v->status === 'scheduled')
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-100 text-blue-900 border border-blue-200">
                                    مجدولة
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-900 border border-emerald-300">
                                    مكتملة ✓
                                </span>
                            @endif
                        </div>

                        <div class="text-xs text-slate-500 flex flex-wrap items-center gap-3 mt-1">
                            <span>حالة التعاقد: <b class="text-slate-800">{{ $v->contract ? 'متعاقد (' . $v->contract->title . ')' : 'غير متعاقد' }}</b></span>
                            <span>•</span>
                            <span>النطاق الجغرافي: <b>{{ $v->location_zone === 'inside_city' ? 'داخل المدينة' : 'خارج المدينة' }}</b></span>
                            <span>•</span>
                            <span>رسوم الزيارة: <b class="font-mono font-bold text-slate-900">{{ $v->visit_fee > 0 ? number_format($v->visit_fee, 2) . ' ر.س (' . $v->fee_status . ')' : 'مغطى بالعقد السنوي' }}</b></span>
                        </div>
                    </div>

                    <!-- Unpaid Spare Parts Warning Badge -->
                    @if($v->has_unpaid_parts)
                        <div class="p-3 bg-red-50 border border-red-200 rounded-xl text-xs text-red-900 max-w-md space-y-1">
                            <div class="flex items-center gap-1.5 font-bold text-red-700">
                                <span>🚨</span>
                                <span>أنظمة بها ملاحظات ولم يتم سداد قيمة قطع الغيار</span>
                            </div>
                            <div class="text-[11px] text-red-800">{{ $v->unpaid_parts_notes }}</div>
                            <div class="text-[11px] font-mono font-bold text-red-900">المبلغ المعلق: {{ number_format($v->unpaid_parts_amount, 2) }} ر.س</div>
                        </div>
                    @endif

                </div>

                <!-- Visit Details & Report Attachment Section -->
                <div class="grid lg:grid-cols-12 gap-4 items-center">
                    
                    <div class="lg:col-span-7 text-xs text-slate-600 space-y-1.5 bg-slate-50 p-4 rounded-xl border border-slate-200">
                        <div><b>المهندس الفاحص:</b> {{ $v->engineer->name ?? 'لم يعين' }} • <b>المشرف الميداني:</b> {{ $v->supervisor->name ?? 'إدارة العمليات' }}</div>
                        <div><b>الموعد والوقت:</b> <span class="font-mono font-bold text-slate-800">{{ $v->scheduled_at->format('Y-m-d h:i A') }}</span> • <b>المدينة:</b> {{ $v->facility->city ?? 'الرياض' }} ({{ $v->facility->district ?? '' }})</div>
                        <div class="text-slate-700 pt-1 border-t border-slate-200 mt-1"><b>الغرض من الفحص:</b> {{ $v->purpose }}</div>
                        
                        <!-- Mini Image Gallery Snippet if images exist -->
                        @if($v->images->count() > 0)
                            <div class="pt-2 flex items-center gap-2">
                                <span class="text-[11px] font-bold text-slate-500">الصور المرفقة ({{ $v->images->count() }}):</span>
                                <div class="flex items-center gap-1">
                                    @foreach($v->images->take(3) as $img)
                                        <img src="{{ $img->image_path }}" alt="صورة الفحص" class="w-7 h-7 rounded object-cover border border-slate-300">
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Visit Controls & Report Slot -->
                    <div class="lg:col-span-5 bg-white p-4 rounded-xl border border-slate-200 space-y-3">
                        <div class="flex items-center justify-between text-xs font-bold text-slate-900">
                            <span>📄 تقرير الفحص ومستندات الموقع:</span>
                            <span class="text-[10px] text-slate-400">PDF / صور</span>
                        </div>

                        @if($v->report)
                            <div class="p-2.5 bg-slate-50 rounded-lg border border-slate-200 flex items-center justify-between text-xs">
                                <div>
                                    <b class="text-slate-900 block text-[11px] truncate max-w-[180px]">#{{ $v->report->report_number }}</b>
                                    <span class="text-[10px] text-emerald-600 font-bold">{{ $v->report->overall_status_arabic }}</span>
                                </div>
                                <a href="{{ route('dashboard.reports.show', $v->report->id) }}" class="px-2.5 py-1 bg-slate-900 hover:bg-slate-800 text-white rounded font-bold text-[11px]">
                                    معاينة التقرير ⬇
                                </a>
                            </div>
                        @else
                            <div class="p-2.5 bg-slate-50 rounded-lg border border-dashed border-slate-300 text-center text-xs text-slate-500">
                                <span>لم يتم إرفاق التقرير بعد</span>
                            </div>
                        @endif

                        <!-- Live Execution Button -->
                        <a href="{{ route('dashboard.visits.manage', $v->id) }}" class="w-full block text-center py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-bold shadow transition-colors">
                            إدارة الموقع وتوثيق الصور وقطع الغيار 📷
                        </a>
                    </div>

                </div>

            </div>
        @empty
            <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center text-slate-500 space-y-3">
                <span class="text-4xl block">👷</span>
                <b class="text-sm text-slate-800">لا توجد زيارات مطابقة للفلتر المحدد</b>
                <p class="text-xs text-slate-400">يمكنك جدولة زيارة جديدة باستخدام الزر بالأعلى.</p>
            </div>
        @endforelse

    </div>

    <!-- SCHEDULE NEW VISIT MODAL (Full Interactive Form) -->
    <dialog id="schedule-visit-modal" class="rounded-3xl border border-slate-200 p-0 shadow-2xl w-full max-w-2xl bg-white backdrop:bg-slate-900/60">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50 rounded-t-3xl">
            <div class="flex items-center gap-2">
                <span class="text-xl">👷</span>
                <h3 class="text-sm sm:text-base font-bold text-slate-900">جدولة زيارة ميدانية جديدة (Field Visit)</h3>
            </div>
            <button onclick="document.getElementById('schedule-visit-modal').close()" class="p-1 rounded-lg text-slate-400 hover:text-slate-700">✕</button>
        </div>

        <form action="{{ route('dashboard.visits.store') }}" method="POST" class="p-6 space-y-4 text-xs">
            @csrf

            <!-- Facility Selection -->
            <div>
                <label class="block font-bold text-slate-700 mb-1">اختر المنشأة / العميل <span class="text-red-500">*</span></label>
                <select name="facility_id" id="facility_select" onchange="updateZonePrice(this)" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800 focus:outline-none focus:border-blue-500">
                    <option value="">-- حدد المنشأة المستهدفة --</option>
                    @foreach($facilities as $f)
                        <option value="{{ $f->id }}" data-zone="{{ $f->zone_type }}" data-has-contract="{{ $f->activeContract ? 'yes' : 'no' }}">
                            {{ $f->name }} ({{ $f->city }}) - {{ $f->activeContract ? '🟢 متعاقد' : '⚪ غير متعاقد' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Visit Type & Zone Pricing Preview -->
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">نوع الزيارة <span class="text-red-500">*</span></label>
                    <select name="visit_type" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800">
                        <option value="quarterly_inspection">فحص ربع سنوي دوري (Quarterly Inspection)</option>
                        <option value="emergency">زيارة طارئة لعطل حرج (Emergency)</option>
                        <option value="pre_contract_audit">معاينة ما قبل التعاقد (Pre-Contract Audit)</option>
                        <option value="corrective_maintenance">صيانة تصحيحية وإصلاح أعطال</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">النطاق الجغرافي والتسعيرة <span class="text-red-500">*</span></label>
                    <select name="location_zone" id="location_zone_select" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800">
                        <option value="inside_city">داخل نطاق المدينة ({{ $company->zone_rate_inside ?? 350 }} ر.س لغير المتعاقد)</option>
                        <option value="outside_city">خارج نطاق المدينة والمناطق النائية ({{ $company->zone_rate_outside ?? 650 }} ر.س)</option>
                    </select>
                </div>
            </div>

            <!-- Date & Time Slot -->
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">تاريخ الزيارة <span class="text-red-500">*</span></label>
                    <input type="date" name="scheduled_date" value="{{ date('Y-m-d') }}" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800 font-mono">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">وقت الزيارة <span class="text-red-500">*</span></label>
                    <input type="time" name="scheduled_time" value="10:00" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800 font-mono">
                </div>
            </div>

            <!-- Engineer & Supervisor Assignment -->
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">إسناد المهندس الفاحص</label>
                    <select name="assigned_engineer_id" class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800">
                        <option value="">-- اختياري (توجيه فوري) --</option>
                        @foreach($engineers as $eng)
                            <option value="{{ $eng->id }}">{{ $eng->name }} ({{ $eng->job_title ?? 'فني' }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">المشرف الميداني</label>
                    <select name="assigned_supervisor_id" class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800">
                        <option value="">-- اختياري --</option>
                        @foreach($supervisors as $sup)
                            <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Purpose -->
            <div>
                <label class="block font-bold text-slate-700 mb-1">الغرض من الزيارة / تفاصيل الفحص <span class="text-red-500">*</span></label>
                <textarea name="purpose" rows="3" required placeholder="مثال: فحص ضغط مضخات الحريق وتعبئة الطفايات واختبار كواشف الدخان..." class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800"></textarea>
            </div>

            <!-- Submit Button -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-3">
                <button type="button" onclick="document.getElementById('schedule-visit-modal').close()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold">
                    إلغاء
                </button>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-lg shadow-blue-500/20">
                    حفظ وجدولة الزيارة الميدانية ✓
                </button>
            </div>
        </form>
    </dialog>

    <script>
        function toggleReminder(el) {
            const txt = document.getElementById('reminder-status-text');
            if (el.checked) {
                txt.innerText = 'مفعلة ✓';
                txt.className = 'mr-2 text-xs font-bold text-slate-700';
            } else {
                txt.innerText = 'معطلة ✕';
                txt.className = 'mr-2 text-xs font-bold text-red-600';
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

        function updateZonePrice(select) {
            const opt = select.options[select.selectedIndex];
            if (opt) {
                const zone = opt.getAttribute('data-zone');
                const zoneSelect = document.getElementById('location_zone_select');
                if (zone && zoneSelect) {
                    zoneSelect.value = zone;
                }
            }
        }
    </script>

@endsection
