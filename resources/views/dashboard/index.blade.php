@extends('layouts.dashboard')

@section('title', 'الرئيسية والإحصائيات | منصة SaaS لإدارة شركات السلامة')
@section('page_title', 'لوحة القيادة والمؤشرات التشغيلية للسلامة الميدانية')

@section('content')

    <!-- 1. TOP WELCOME & QUICK ACTIONS -->
    <div class="bg-gradient-to-r from-slate-900 via-blue-950 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl mb-8 relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
        
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 relative z-10">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-300 text-xs font-bold">
                    <span>🏢 {{ $company->name ?? 'شركة نبيكو العربية للسلامة' }}</span>
                    <span>•</span>
                    <span class="text-emerald-400">خطة SaaS: {{ strtoupper($company->subscription_plan ?? 'ENTERPRISE') }}</span>
                </div>
                <h2 class="text-xl sm:text-2xl font-black">
                    مرحباً بك، {{ $user['name'] ?? 'المدير التنفيذي' }} 👋
                </h2>
                <p class="text-xs sm:text-sm text-slate-300 max-w-2xl leading-relaxed">
                    منظومة SaaS الشاملة لإدارة عقود الصيانة، جدولة زيارات مهندسي الفحص الميداني، تسعير النطاق الجغرافي، توثيق صور المواقع، وحصر قطع الغيار غير المسددة.
                </p>
            </div>

            <!-- Quick Action Buttons -->
            <div class="flex flex-wrap gap-2.5 shrink-0">
                <a href="{{ route('dashboard.visits') }}" class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold shadow-lg shadow-blue-600/30 transition-all flex items-center gap-2">
                    <span>➕</span>
                    <span>جدولة زيارة فحص</span>
                </a>
                <a href="{{ route('dashboard.maintenance_requests.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white text-xs font-bold border border-slate-700 transition-all flex items-center gap-2">
                    <span>📥</span>
                    <span>طلب صيانة جديد</span>
                </a>
                <a href="{{ route('dashboard.saas_settings') }}" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold shadow-lg shadow-emerald-600/20 transition-all flex items-center gap-2">
                    <span>⚙️</span>
                    <span>إعدادات SaaS</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 2. KPI METRICS CARDS (Real Database Stats) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
        
        <!-- Active Contracts -->
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-3 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500">العقود السارية</span>
                <span class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">🌲</span>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-black font-mono text-slate-900">{{ $stats['active_contracts'] }}</div>
                <div class="text-[11px] text-slate-400 mt-1 font-semibold">من إجمالي {{ \App\Models\Contract::count() }} عقد مسجل</div>
            </div>
        </div>

        <!-- Scheduled & In-Progress Visits -->
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-3 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500">زيارات ميدانية نشطة</span>
                <span class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">👷</span>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-black font-mono text-emerald-600">
                    {{ $stats['scheduled_visits'] + $stats['in_progress_visits'] }}
                </div>
                <div class="text-[11px] text-slate-500 mt-1 flex gap-2 font-semibold">
                    <span>مجدولة: <b>{{ $stats['scheduled_visits'] }}</b></span>
                    <span>•</span>
                    <span>جارية الآن: <b>{{ $stats['in_progress_visits'] }}</b></span>
                </div>
            </div>
        </div>

        <!-- Pending Maintenance Requests -->
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-3 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500">طلبات الصيانة المعلقة</span>
                <span class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg">📥</span>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-black font-mono text-purple-700">{{ $stats['pending_requests'] }}</div>
                <div class="text-[11px] text-purple-600 mt-1 font-semibold">تتطلب توجيه مهندس فحص</div>
            </div>
        </div>

        <!-- Unpaid Spare Parts Amount Warning Card -->
        <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl border border-amber-300 p-5 shadow-sm space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-amber-900">قطع غيار غير مسددة</span>
                <span class="w-10 h-10 rounded-xl bg-amber-200 text-amber-900 flex items-center justify-center text-lg">⚠️</span>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-black font-mono text-amber-950">
                    {{ number_format($stats['unpaid_parts_total'], 0) }} <span class="text-xs">ر.س</span>
                </div>
                <div class="text-[11px] text-amber-800 mt-1 font-bold">
                    في {{ $stats['unpaid_parts_count'] }} زيارات تحتاج تحصيل مالي
                </div>
            </div>
        </div>

    </div>

    <!-- 3. UNPAID SPARE PARTS SYSTEM WARNING BANNER -->
    @if($stats['unpaid_parts_count'] > 0)
        <div class="bg-amber-500/10 border-2 border-amber-400 rounded-2xl p-5 mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-amber-500 text-white flex items-center justify-center text-2xl shrink-0 shadow-md">
                    ⚠️
                </div>
                <div>
                    <h3 class="text-sm sm:text-base font-extrabold text-amber-950">
                        تنبيه تحصيل قطع الغيار: توجد {{ $stats['unpaid_parts_count'] }} زيارات تم تسجيل قطع غيار مستبدلة ولم يتم سداد قيمتها!
                    </h3>
                    <p class="text-xs text-amber-900 mt-0.5">
                        إجمالي المبالغ المعلقة: <b class="font-mono">{{ number_format($stats['unpaid_parts_total'], 2) }} ر.س</b> — يرجى مراجعة إدارة التحصيل والمهندس المشرف قبل إصدار شهادة السلامة النهائية.
                    </p>
                </div>
            </div>
            <a href="{{ route('dashboard.visits', ['unpaid_only' => 1]) }}" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold shrink-0 shadow-sm transition-colors">
                عرض الزيارات المعلقة ({{ $stats['unpaid_parts_count'] }})
            </a>
        </div>
    @endif

    <!-- 4. MAIN DASHBOARD CONTENT GRID (Recent Visits & Live Maintenance Requests) -->
    <div class="grid lg:grid-cols-12 gap-8 mb-8">
        
        <!-- Left 8 Cols: Recent Field Visits with Execution Links -->
        <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-5">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div class="flex items-center gap-2">
                    <span class="text-xl">👷</span>
                    <h3 class="text-sm font-bold text-slate-900">جدول الزيارات الميدانية والتنفيذ الحي</h3>
                </div>
                <a href="{{ route('dashboard.visits') }}" class="text-xs font-bold text-blue-600 hover:underline">
                    عرض جميع الزيارات ({{ \App\Models\Visit::count() }}) ←
                </a>
            </div>

            <div class="space-y-3">
                @forelse($recentVisits as $v)
                    <div class="p-4 rounded-xl border {{ $v->has_unpaid_parts ? 'border-amber-300 bg-amber-50/40' : 'border-slate-200 bg-slate-50/60' }} hover:border-blue-300 transition-all flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        
                        <div class="space-y-1.5 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="font-mono font-bold text-xs bg-slate-900 text-white px-2 py-0.5 rounded">#{{ $v->visit_number }}</span>
                                <h4 class="text-xs sm:text-sm font-bold text-slate-900">{{ $v->facility->name ?? 'منشأة عامة' }}</h4>
                                
                                @if($v->status === 'in_progress')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-900 border border-amber-300 animate-pulse">
                                        قيد التنفيذ الآن
                                    </span>
                                @elseif($v->status === 'scheduled')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-900 border border-blue-200">
                                        مجدولة
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-900 border border-emerald-300">
                                        مكتملة ✓
                                    </span>
                                @endif

                                @if($v->has_unpaid_parts)
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-800 border border-red-200">
                                        ⚠️ قطع غير مسددة ({{ number_format($v->unpaid_parts_amount, 0) }} ر.س)
                                    </span>
                                @endif
                            </div>

                            <p class="text-xs text-slate-600 line-clamp-1">
                                {{ $v->purpose }}
                            </p>

                            <div class="flex flex-wrap items-center gap-3 text-[11px] text-slate-500">
                                <span>المهندس: <b>{{ $v->engineer->name ?? 'لم يعين' }}</b></span>
                                <span>•</span>
                                <span>الموعد: <b class="font-mono text-slate-700">{{ $v->scheduled_at->format('Y-m-d h:i A') }}</b></span>
                                <span>•</span>
                                <span>النطاق: <b>{{ $v->location_zone === 'inside_city' ? 'داخل المدينة (350 ر.س)' : 'خارج المدينة (650 ر.س)' }}</b></span>
                            </div>
                        </div>

                        <!-- Action Button to Open Site Management / Execution View -->
                        <div class="shrink-0 flex sm:flex-col items-center gap-2">
                            <a href="{{ route('dashboard.visits.manage', $v->id) }}" class="px-3.5 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition-colors w-full text-center">
                                إدارة وتوثيق الموقع 📷
                            </a>
                            @if($v->report)
                                <a href="{{ route('dashboard.reports.show', $v->report->id) }}" class="px-2 py-1 text-[11px] font-bold text-emerald-700 hover:underline">
                                    معاينة التقرير 📄
                                </a>
                            @endif
                        </div>

                    </div>
                @empty
                    <div class="text-center py-8 text-xs text-slate-500">لا توجد زيارات مسجلة حالياً.</div>
                @endforelse
            </div>
        </div>

        <!-- Right 4 Cols: Recent Maintenance Requests & Automated Reminders -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Maintenance Requests Box -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                        <span>📥</span>
                        <span>أحدث طلبات الصيانة</span>
                    </h3>
                    <a href="{{ route('dashboard.maintenance_requests.index') }}" class="text-[11px] text-blue-600 font-bold hover:underline">
                        عرض الكل
                    </a>
                </div>

                <div class="space-y-3">
                    @forelse($recentRequests as $req)
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 space-y-1.5 text-xs">
                            <div class="flex items-center justify-between">
                                <b class="text-slate-900 truncate">{{ $req->facility->name ?? 'منشأة' }}</b>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $req->priority_badge_color }}">
                                    {{ $req->priority === 'critical' ? 'طارئ حرج' : 'عادي' }}
                                </span>
                            </div>
                            <p class="text-[11px] text-slate-600 line-clamp-2">{{ $req->title }}</p>
                            <div class="flex items-center justify-between pt-1 text-[10px] text-slate-400">
                                <span>#{{ $req->request_number }}</span>
                                <span class="font-mono">{{ $req->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-xs text-slate-500">لا توجد طلبات معلقة.</div>
                    @endforelse
                </div>
            </div>

            <!-- Notifications & 48h Reminder Feed -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                        <span>🔔</span>
                        <span>إشعارات وتنبيهات النظام</span>
                    </h3>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-blue-100 text-blue-800">SMS & Alert</span>
                </div>

                <div class="space-y-2.5">
                    @forelse($notifications as $notif)
                        <div class="p-2.5 rounded-xl border {{ $notif->priority === 'warning' ? 'bg-amber-50/50 border-amber-200 text-amber-900' : 'bg-slate-50 border-slate-200 text-slate-800' }} text-xs space-y-1">
                            <div class="font-bold flex items-center justify-between">
                                <span class="truncate">{{ $notif->title }}</span>
                                <span class="text-[10px] font-mono text-slate-400 shrink-0">{{ $notif->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-[11px] text-slate-600 leading-snug">{{ $notif->message }}</p>
                        </div>
                    @empty
                        <div class="text-center py-4 text-xs text-slate-500">لا توجد إشعارات.</div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

@endsection
