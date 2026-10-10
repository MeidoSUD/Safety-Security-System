@extends('layouts.dashboard')

@section('title', 'الرئيسية والإحصائيات | نبيكو ERP')

@section('content')

    <!-- ========================================================================= -->
    <!-- 1. ROLE: CLIENT (بوابة العميل والمنشأة)                                    -->
    <!-- ========================================================================= -->
    @if($role === 'client')
        @section('page_title', 'بوابة العميل ومتابعة سلامة المنشأة')
        
        <!-- Client Hero Banner -->
        <div class="bg-gradient-to-r from-blue-950 via-slate-900 to-indigo-950 rounded-3xl p-6 sm:p-8 text-white shadow-xl mb-8 relative overflow-hidden">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 relative z-10">
                <div class="space-y-2">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-bold border border-emerald-500/30">
                        <span>🏫 منشأة معتمدة من الدفاع المدني</span>
                        <span>•</span>
                        <span>نسبة الامتثال للسلامة: 98%</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black">
                        مرحباً بك، {{ $userSession['name'] }} 👋
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-300 max-w-2xl leading-relaxed">
                        بوابة متابعة عقود الصيانة الدورية، رخص الدفاع المدني، تقارير فحص شبكات الإطفاء والإنذار، وتقديم بلاغات الصيانة الطارئة الفورية.
                    </p>
                </div>

                <div class="flex flex-wrap gap-2.5 shrink-0">
                    <button onclick="document.getElementById('client-request-modal').showModal()" class="px-4 py-2.5 rounded-xl bg-red-600 hover:bg-red-500 text-white text-xs font-bold shadow-lg shadow-red-600/30 transition-all flex items-center gap-2">
                        <span>🚨</span>
                        <span>تقديم بلاغ / طلب صيانة طارئ</span>
                    </button>
                    <a href="{{ route('dashboard.reports') }}" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white text-xs font-bold border border-slate-700 transition-all flex items-center gap-2">
                        <span>📄</span>
                        <span>شهادات السلامة</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Client KPI Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-2">
                <div class="flex items-center justify-between text-slate-500 text-xs font-bold">
                    <span>المنشآت المسجلة</span>
                    <span class="text-lg">🏫</span>
                </div>
                <div class="text-2xl sm:text-3xl font-black font-mono text-slate-900">{{ $stats['my_facilities_count'] }}</div>
                <div class="text-[11px] text-emerald-600 font-bold">● رخصة الدفاع المدني سارية</div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-2">
                <div class="flex items-center justify-between text-slate-500 text-xs font-bold">
                    <span>عقد الصيانة السنوي</span>
                    <span class="text-lg">🌲</span>
                </div>
                <div class="text-2xl sm:text-3xl font-black font-mono text-blue-600">{{ $stats['active_contracts_count'] }} نشط</div>
                <div class="text-[11px] text-slate-500">حصة الزيارات: 1 من 4 زيارات</div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-2">
                <div class="flex items-center justify-between text-slate-500 text-xs font-bold">
                    <span>الزيارات المجدولة</span>
                    <span class="text-lg">📅</span>
                </div>
                <div class="text-2xl sm:text-3xl font-black font-mono text-purple-600">{{ $stats['upcoming_visits_count'] }}</div>
                <div class="text-[11px] text-purple-600 font-bold">فحص دوري Q3</div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-2">
                <div class="flex items-center justify-between text-slate-500 text-xs font-bold">
                    <span>تقارير الفحص الصادرة</span>
                    <span class="text-lg">📄</span>
                </div>
                <div class="text-2xl sm:text-3xl font-black font-mono text-emerald-600">{{ $stats['my_reports_count'] }}</div>
                <div class="text-[11px] text-slate-500">جاهزة للتحميل والطباعة</div>
            </div>
        </div>

        <!-- Client Facilities & Visits Grid -->
        <div class="grid lg:grid-cols-12 gap-6 mb-8">
            <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                        <span>🏫</span>
                        <span>منشأتي وأنظمة السلامة المركبة</span>
                    </h3>
                </div>

                <div class="space-y-3">
                    @forelse($clientFacilities as $fac)
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <div>
                                    <h4 class="font-bold text-sm text-slate-900">{{ $fac->name }}</h4>
                                    <div class="text-xs text-slate-500">{{ $fac->city }} • {{ $fac->district }}</div>
                                </div>
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                    رخصة الدفاع المدني: {{ $fac->safety_license_number ?? 'SL-EDU-2025-091' }}
                                </span>
                            </div>

                            <div class="grid sm:grid-cols-3 gap-2 text-xs pt-2 border-t border-slate-200">
                                <div class="bg-white p-2 rounded-lg border border-slate-200">
                                    <span class="text-slate-400 block text-[10px]">مضخات الحريق:</span>
                                    <b class="text-emerald-700">سليمة 100% (10 بار)</b>
                                </div>
                                <div class="bg-white p-2 rounded-lg border border-slate-200">
                                    <span class="text-slate-400 block text-[10px]">شبكة الإنذار:</span>
                                    <b class="text-emerald-700">معنونة وفحص كامل</b>
                                </div>
                                <div class="bg-white p-2 rounded-lg border border-slate-200">
                                    <span class="text-slate-400 block text-[10px]">طفايات الحريق:</span>
                                    <b class="text-slate-800">142 طفاية معبأة</b>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-xs text-slate-400">لا توجد منشآت مسجلة.</div>
                    @endforelse
                </div>
            </div>

            <!-- Client Quick Requests Box -->
            <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                        <span>🚨</span>
                        <span>طلبات الصيانة الخاصة بي</span>
                    </h3>
                </div>

                <div class="space-y-2.5">
                    @forelse($clientRequests as $cr)
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs space-y-1">
                            <div class="flex items-center justify-between font-bold">
                                <span class="text-slate-900 truncate">{{ $cr->title }}</span>
                                <span class="text-[10px] px-2 py-0.5 rounded bg-amber-100 text-amber-900">{{ $cr->status }}</span>
                            </div>
                            <div class="text-[10px] text-slate-400 font-mono">{{ $cr->created_at->format('Y-m-d') }}</div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-xs text-slate-400">لا توجد بلاغات معلقة حالياً. جميع الأنظمة تعمل بكفاءة.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- CLIENT EMERGENCY REQUEST MODAL -->
        <dialog id="client-request-modal" class="rounded-3xl border border-slate-200 p-0 shadow-2xl w-full max-w-lg bg-white backdrop:bg-slate-900/60">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50 rounded-t-3xl">
                <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                    <span>🚨</span>
                    <span>رفع بلاغ صيانة / طلب طوارئ للمنشأة</span>
                </h3>
                <button onclick="document.getElementById('client-request-modal').close()" class="text-slate-400 hover:text-slate-700">✕</button>
            </div>

            <form action="{{ route('dashboard.maintenance_requests.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 text-xs">
                @csrf
                <input type="hidden" name="facility_id" value="{{ $clientFacilities->first()->id ?? 2 }}">
                <input type="hidden" name="type" value="emergency">
                <input type="hidden" name="priority" value="critical">

                <div>
                    <label class="block font-bold text-slate-700 mb-1">النظام المعني بالعطل <span class="text-red-500">*</span></label>
                    <select name="system_type" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800">
                        <option value="fire_alarm">لوحة إنذار الحريق والكواشف</option>
                        <option value="fire_pumps">مضخات الحريق والضغط</option>
                        <option value="sprinklers">شبكة الرشاشات المائية</option>
                        <option value="fire_extinguishers">طفايات وصناديق الحريق</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">عنوان البلاغ <span class="text-red-500">*</span></label>
                    <input type="text" name="title" required placeholder="مثال: صوت إنذار متكرر في الدور الثاني" class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">وصف العطل / المشكلة</label>
                    <textarea name="description" rows="3" placeholder="تفاصيل إضافية لمساعدة الفنيين..." class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs"></textarea>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">إرفاق صورة للمشكلة إن وجدت</label>
                    <input type="file" name="site_photo_file" accept="image/*" class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2 text-xs">
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                    <button type="button" onclick="document.getElementById('client-request-modal').close()" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl font-bold">إلغاء</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-xl font-bold">إرسال بلاغ الطوارئ 🚨</button>
                </div>
            </form>
        </dialog>

    <!-- ========================================================================= -->
    <!-- 2. ROLE: TECHNICIAN (بوابة مهندس وفني الفحص الميداني)                     -->
    <!-- ========================================================================= -->
    @elseif($role === 'technician')
        @section('page_title', 'لوحة مهام الفني والزيارات الميدانية')
        
        <!-- Technician Top Header -->
        <div class="bg-gradient-to-r from-slate-900 via-blue-900 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/20 text-amber-300 text-xs font-bold border border-amber-500/30">
                        <span>👷 مهندس الفحص الميداني المعتمد</span>
                        <span>•</span>
                        <span>{{ $currentUser->name ?? 'فني أحمد القحطاني' }}</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black">
                        مهامي وزياراتي الميدانية اليوم 🛠️
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-300 max-w-2xl leading-relaxed">
                        قم بتوثيق فحص المواقع، رفع صور الأعطال قبل وبعد، تسجيل قطع الغيار المستبدلة، وتعبئة استمارات الفحص المعتمدة فوراً من هاتفك أو جهازك اللوحي.
                    </p>
                </div>
            </div>
        </div>

        <!-- Technician KPI Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-2">
                <div class="flex items-center justify-between text-slate-500 text-xs font-bold">
                    <span>زيارات اليوم المجدولة</span>
                    <span class="text-lg">📍</span>
                </div>
                <div class="text-2xl sm:text-3xl font-black font-mono text-blue-600">{{ $stats['today_visits_count'] }}</div>
                <div class="text-[11px] text-slate-400">مجدولة وجاهزة للتنفيذ</div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-2">
                <div class="flex items-center justify-between text-slate-500 text-xs font-bold">
                    <span>قيد التنفيذ الآن</span>
                    <span class="text-lg">⚡</span>
                </div>
                <div class="text-2xl sm:text-3xl font-black font-mono text-amber-600">{{ $stats['in_progress_count'] }}</div>
                <div class="text-[11px] text-amber-700 font-bold">في الموقع الميداني</div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-2">
                <div class="flex items-center justify-between text-slate-500 text-xs font-bold">
                    <span>تقارير تنتظر التعبئة</span>
                    <span class="text-lg">📝</span>
                </div>
                <div class="text-2xl sm:text-3xl font-black font-mono text-purple-600">{{ $stats['pending_reports_count'] }}</div>
                <div class="text-[11px] text-purple-600 font-bold">استمارات فحص</div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-2">
                <div class="flex items-center justify-between text-slate-500 text-xs font-bold">
                    <span>الزيارات المنجزة</span>
                    <span class="text-lg">✓</span>
                </div>
                <div class="text-2xl sm:text-3xl font-black font-mono text-emerald-600">{{ $stats['completed_count'] }}</div>
                <div class="text-[11px] text-emerald-600 font-bold">مكتملة ومعتمدة</div>
            </div>
        </div>

        <!-- Assigned Visits Task Cards -->
        <div class="space-y-4 mb-8">
            <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                <span>👷</span>
                <span>قائمة الزيارات الميدانية المسندة إليك:</span>
            </h3>

            @forelse($assignedVisits as $av)
                <div class="bg-white rounded-2xl border {{ $av->status === 'in_progress' ? 'border-amber-400 ring-2 ring-amber-100' : 'border-slate-200' }} p-6 shadow-sm space-y-4">
                    <div class="flex flex-wrap items-start justify-between gap-4 border-b border-slate-100 pb-4">
                        <div class="space-y-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="font-mono text-xs font-bold bg-slate-900 text-white px-2 py-0.5 rounded">#{{ $av->visit_number }}</span>
                                <h4 class="text-base font-bold text-slate-900">{{ $av->facility->name }}</h4>
                                <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-blue-50 text-blue-700">{{ $av->type_arabic }}</span>
                                
                                @if($av->status === 'in_progress')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-900 animate-pulse">
                                        قيد التنفيذ الآن
                                    </span>
                                @elseif($av->status === 'scheduled')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-900">
                                        مجدولة
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-900">
                                        مكتملة ✓
                                    </span>
                                @endif
                            </div>

                            <p class="text-xs text-slate-600">{{ $av->purpose }}</p>

                            <div class="text-[11px] text-slate-500 flex flex-wrap gap-3 pt-1">
                                <span>الموقع: <b>{{ $av->facility->city }} - {{ $av->facility->district }}</b></span>
                                <span>•</span>
                                <span>الموعد: <b class="font-mono text-slate-800">{{ $av->scheduled_at->format('Y-m-d h:i A') }}</b></span>
                                <span>•</span>
                                <span>مسؤول الموقع: <b>{{ $av->facility->contact_person }} ({{ $av->facility->contact_phone }})</b></span>
                            </div>
                        </div>

                        <!-- 1-Click Action for Technician -->
                        <a href="{{ route('dashboard.visits.manage', $av->id) }}" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-lg shadow-blue-500/20 transition-all flex items-center gap-2">
                            <span>📷</span>
                            <span>فتح الموقع وتوثيق الفحص والقطع</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center text-slate-400">
                    لا توجد مهام زيارات مسندة حالياً.
                </div>
            @endforelse
        </div>

    <!-- ========================================================================= -->
    <!-- 3. ROLE: SUPERVISOR (مشرف الميدان والفنيين)                                 -->
    <!-- ========================================================================= -->
    @elseif($role === 'supervisor')
        @section('page_title', 'غرفة عمليات الميدان ومتابعة الفنيين')

        <!-- Supervisor Top Header -->
        <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/20 text-blue-300 text-xs font-bold border border-blue-500/30">
                        <span>🛡️ مشرف الميدان والفنيين</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black">
                        متابعة الفرق الميدانية وتدقيق التقارير والقطع 🛡️
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-300 max-w-2xl leading-relaxed">
                        توجيه المهندسين والفنيين، مراقبة الزيارات الميدانية الحية، مراجعة استمارات الفحص، وحصر قطع الغيار غير المسددة قبل إصدار الشهادات.
                    </p>
                </div>
                <a href="{{ route('dashboard.visits') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-500 text-white rounded-xl text-xs font-bold shadow transition-all shrink-0 flex items-center gap-2">
                    <span>➕</span>
                    <span>توزيع وجدولة زيارة</span>
                </a>
            </div>
        </div>

        <!-- Supervisor KPI Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-2">
                <div class="flex items-center justify-between text-slate-500 text-xs font-bold">
                    <span>الزيارات الميدانية النشطة</span>
                    <span class="text-lg">⚡</span>
                </div>
                <div class="text-2xl sm:text-3xl font-black font-mono text-amber-600">{{ $stats['active_in_field'] }}</div>
                <div class="text-[11px] text-amber-700 font-bold">فنيين في المواقع الآن</div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-2">
                <div class="flex items-center justify-between text-slate-500 text-xs font-bold">
                    <span>الفنيين المسجلين</span>
                    <span class="text-lg">👷</span>
                </div>
                <div class="text-2xl sm:text-3xl font-black font-mono text-blue-600">{{ $stats['active_technicians'] }}</div>
                <div class="text-[11px] text-slate-400">فرق الإطفاء والإنذار</div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-2">
                <div class="flex items-center justify-between text-slate-500 text-xs font-bold">
                    <span>تقارير بانتظار الاعتماد</span>
                    <span class="text-lg">📝</span>
                </div>
                <div class="text-2xl sm:text-3xl font-black font-mono text-purple-600">{{ $stats['pending_reports_review'] }}</div>
                <div class="text-[11px] text-purple-600 font-bold">تتطلب مراجعة المشرف</div>
            </div>

            <div class="bg-amber-50 rounded-2xl border border-amber-300 p-5 shadow-sm space-y-2">
                <div class="flex items-center justify-between text-amber-900 text-xs font-bold">
                    <span>قطع غيار غير مسددة</span>
                    <span class="text-lg">⚠️</span>
                </div>
                <div class="text-2xl sm:text-3xl font-black font-mono text-amber-950">{{ number_format($stats['unpaid_parts_total'], 0) }} ر.س</div>
                <div class="text-[11px] text-amber-800 font-bold">في {{ $stats['unpaid_parts_count'] }} زيارات</div>
            </div>
        </div>

        <!-- Supervisor Live Field Grid -->
        <div class="grid lg:grid-cols-12 gap-6 mb-8">
            <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
                    <span>👷</span>
                    <span>الزيارات الميدانية وحالة الفنيين</span>
                </h3>
                <div class="space-y-3">
                    @foreach($supervisorVisits->take(5) as $sv)
                        <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50 flex items-center justify-between gap-3 text-xs">
                            <div>
                                <b class="text-slate-900 block text-xs">{{ $sv->facility->name }}</b>
                                <span class="text-[11px] text-slate-500">الفني: {{ $sv->engineer->name ?? 'غير مسند' }} • {{ $sv->scheduled_at->format('h:i A') }}</span>
                            </div>
                            <a href="{{ route('dashboard.visits.manage', $sv->id) }}" class="px-3 py-1.5 bg-slate-900 text-white rounded-lg font-bold text-xs">
                                متابعة الفحص 🔍
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-4">
                <h3 class="text-xs font-bold text-slate-900 flex items-center gap-1.5 border-b border-slate-100 pb-3">
                    <span>⚠️</span>
                    <span>تنبيهات قطع الغيار بالميدان</span>
                </h3>
                <div class="space-y-2">
                    @foreach($unpaidVisits as $uv)
                        <div class="p-2.5 rounded-xl bg-amber-50 border border-amber-200 text-xs space-y-1">
                            <b class="text-amber-950 block text-[11px]">{{ $uv->facility->name }}</b>
                            <span class="text-[10px] text-red-700 font-bold font-mono block">المبلغ: {{ number_format($uv->unpaid_parts_amount, 2) }} ر.س</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    <!-- ========================================================================= -->
    <!-- 4. ROLE: OPERATIONS MANAGER (مدير العمليات والعقود)                         -->
    <!-- ========================================================================= -->
    @elseif($role === 'manager')
        @section('page_title', 'لوحة إدارة العمليات والعقود والصيانة')

        <!-- Manager Top Banner -->
        <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/20 text-blue-300 text-xs font-bold border border-blue-500/30">
                        <span>🏢 مدير العمليات والعقود</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black">
                        إدارة عقود الصيانة، حصص الزيارات، وبلاغات المواقع 🏢
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-300 max-w-2xl leading-relaxed">
                        متابعة تجديدات عقود الصيانة AMC، إدارة حصص الزيارات السنوية، والبت في طلبات الصيانة وتوجيه المهندسين.
                    </p>
                </div>
                <div class="flex gap-2 shrink-0">
                    <a href="{{ route('dashboard.contracts') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-500 text-white rounded-xl text-xs font-bold shadow transition-all">
                        ➕ إنشاء عقد جديد
                    </a>
                </div>
            </div>
        </div>

        <!-- Manager KPI Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-2">
                <div class="flex items-center justify-between text-slate-500 text-xs font-bold">
                    <span>العقود السارية</span>
                    <span class="text-lg">🌲</span>
                </div>
                <div class="text-2xl sm:text-3xl font-black font-mono text-emerald-600">{{ $stats['active_contracts'] }}</div>
                <div class="text-[11px] text-slate-500">{{ $stats['expiring_contracts'] }} تنتهي خلال 30 يوماً</div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-2">
                <div class="flex items-center justify-between text-slate-500 text-xs font-bold">
                    <span>إجمالي المنشآت</span>
                    <span class="text-lg">🏢</span>
                </div>
                <div class="text-2xl sm:text-3xl font-black font-mono text-slate-900">{{ $stats['total_facilities'] }}</div>
                <div class="text-[11px] text-slate-500">نطاقات داخل وخارج المدينة</div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-2">
                <div class="flex items-center justify-between text-slate-500 text-xs font-bold">
                    <span>طلبات الصيانة المعلقة</span>
                    <span class="text-lg">📥</span>
                </div>
                <div class="text-2xl sm:text-3xl font-black font-mono text-purple-600">{{ $stats['pending_requests'] }}</div>
                <div class="text-[11px] text-purple-600 font-bold">تحتاج توجيه وجدولة</div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-2">
                <div class="flex items-center justify-between text-slate-500 text-xs font-bold">
                    <span>طلبات داخلية معلقة</span>
                    <span class="text-lg">🔄</span>
                </div>
                <div class="text-2xl sm:text-3xl font-black font-mono text-blue-600">{{ $stats['internal_requests_pending'] }}</div>
                <div class="text-[11px] text-slate-400">صرف قطع وأسطول</div>
            </div>
        </div>

    <!-- ========================================================================= -->
    <!-- 5. ROLE: ADMIN (المدير التنفيذي - الإدارة العليا الشاملة)                  -->
    <!-- ========================================================================= -->
    @else
        @section('page_title', 'لوحة القيادة والمؤشرات التنفيذية الشاملة')

        <!-- Admin Hero Banner -->
        <div class="bg-gradient-to-r from-slate-900 via-blue-950 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl mb-8 relative overflow-hidden">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 relative z-10">
                <div class="space-y-2">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-300 text-xs font-bold">
                        <span>🏢 {{ $company->name ?? 'شركة نبيكو العربية للسلامة' }}</span>
                        <span>•</span>
                        <span class="text-emerald-400 font-mono">MySQL Engine</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black">
                        لوحة الإدارة التنفيذية العليا 👑
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-300 max-w-2xl leading-relaxed">
                        نظام SaaS السحابي لإدارة شركات السلامة، عقود الصيانة، تسعير النطاقات، تدقيق تقارير كود البناء السعودي SBC 801، وحسابات المستأجرين.
                    </p>
                </div>

                <div class="flex flex-wrap gap-2.5 shrink-0">
                    <a href="{{ route('dashboard.visits') }}" class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold shadow-lg shadow-blue-600/30 transition-all flex items-center gap-2">
                        <span>➕</span>
                        <span>جدولة زيارة فحص</span>
                    </a>
                    <a href="{{ route('dashboard.saas_settings') }}" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold shadow-lg shadow-emerald-600/20 transition-all flex items-center gap-2">
                        <span>⚙️</span>
                        <span>إعدادات SaaS والبيع</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Admin KPI Metrics Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500">قيمة العقود السارية</span>
                    <span class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">💰</span>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl font-black font-mono text-emerald-700">{{ number_format($stats['total_contracts_value'], 0) }} <span class="text-xs">ر.س</span></div>
                    <div class="text-[11px] text-slate-400 mt-1 font-semibold">{{ $stats['active_contracts'] }} عقد سنوي نشط</div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500">الزيارات الميدانية النشطة</span>
                    <span class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">👷</span>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl font-black font-mono text-blue-600">{{ $stats['scheduled_visits'] + $stats['in_progress_visits'] }}</div>
                    <div class="text-[11px] text-slate-500 mt-1 font-semibold">مجدولة وجارية بالمواقع</div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500">المنشآت والمواقع</span>
                    <span class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg">🏢</span>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl font-black font-mono text-slate-900">{{ $stats['total_facilities'] }}</div>
                    <div class="text-[11px] text-purple-600 mt-1 font-semibold">مواقع ومصانع ومدارس</div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl border border-amber-300 p-5 shadow-sm space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-amber-900">قطع غيار غير مسددة</span>
                    <span class="w-10 h-10 rounded-xl bg-amber-200 text-amber-900 flex items-center justify-center text-lg">⚠️</span>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl font-black font-mono text-amber-950">{{ number_format($stats['unpaid_parts_total'], 0) }} <span class="text-xs">ر.س</span></div>
                    <div class="text-[11px] text-amber-800 mt-1 font-bold">في {{ $stats['unpaid_parts_count'] }} زيارات</div>
                </div>
            </div>
        </div>

        <!-- Admin Visits & Activity Grid -->
        <div class="grid lg:grid-cols-12 gap-8 mb-8">
            <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                        <span>👷</span>
                        <span>أحدث الزيارات الميدانية والتنفيذ الحي</span>
                    </h3>
                    <a href="{{ route('dashboard.visits') }}" class="text-xs font-bold text-blue-600 hover:underline">عرض الكل ←</a>
                </div>

                <div class="space-y-3">
                    @foreach($recentVisits as $v)
                        <div class="p-4 rounded-xl border {{ $v->has_unpaid_parts ? 'border-amber-300 bg-amber-50/40' : 'border-slate-200 bg-slate-50/60' }} flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="font-mono text-xs font-bold bg-slate-900 text-white px-2 py-0.5 rounded">#{{ $v->visit_number }}</span>
                                    <b class="text-xs sm:text-sm text-slate-900">{{ $v->facility->name }}</b>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-800">{{ $v->type_arabic }}</span>
                                </div>
                                <p class="text-xs text-slate-600 line-clamp-1">{{ $v->purpose }}</p>
                                <div class="text-[11px] text-slate-500">الفني: <b>{{ $v->engineer->name ?? 'لم يعين' }}</b> • الموعد: {{ $v->scheduled_at->format('Y-m-d h:i A') }}</div>
                            </div>
                            <a href="{{ route('dashboard.visits.manage', $v->id) }}" class="px-3.5 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition-colors shrink-0 text-center">
                                إدارة الموقع 📷
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                        <span>🔔</span>
                        <span>التنبيهات والتذكيرات</span>
                    </h3>
                </div>

                <div class="space-y-2.5">
                    @foreach($notifications as $notif)
                        <div class="p-2.5 rounded-xl border {{ $notif->priority === 'warning' ? 'bg-amber-50 border-amber-200 text-amber-900' : 'bg-slate-50 border-slate-200 text-slate-800' }} text-xs space-y-1">
                            <b class="block truncate">{{ $notif->title }}</b>
                            <p class="text-[11px] text-slate-600">{{ $notif->message }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    @endif

@endsection
