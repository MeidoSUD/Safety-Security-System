@extends('layouts.dashboard')

@section('title', 'الرئيسية والإحصائيات | نبيكو العربية ERP')
@section('page_title', 'الرئيسية • لوحة مؤشرات الأداء والعمليات')

@section('content')

    <!-- Welcome Role Banner -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 border border-blue-200 flex items-center justify-center text-2xl font-bold">
                {{ $user['avatar'] }}
            </div>
            <div>
                <h2 class="text-lg font-extrabold text-slate-900 flex items-center gap-2">
                    <span>مرحباً، {{ $user['name'] }}</span>
                    <span class="text-xs px-2 py-0.5 rounded bg-slate-100 text-slate-700 border border-slate-200 font-normal">
                        {{ $user['title'] }}
                    </span>
                </h2>
                <p class="text-xs text-slate-500 mt-1">
                    أنت تتصفح النظام الميداني لشركة نبيكو العربية للتشغيل والصيانة.
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('dashboard.contracts') }}" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-lg text-xs font-bold transition-colors">
                استعراض شجرة العقود 🌲
            </a>
            <a href="{{ route('dashboard.visits') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-800 rounded-lg text-xs font-bold transition-colors">
                جدول الزيارات 👷
            </a>
        </div>
    </div>

    <!-- METRICS GRID -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        
        <!-- Metric 1 -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-2">
            <div class="flex items-center justify-between text-xs text-slate-500 font-medium">
                <span>إجمالي العقود السارية</span>
                <span class="text-emerald-700 font-bold">🟢 نشط</span>
            </div>
            <div class="text-3xl font-black text-slate-900 font-mono">{{ $currentStats['active_contracts'] }}</div>
            <div class="text-[11px] text-emerald-700 font-semibold">
                <span>↑ 100% نسبة الامتثال الميداني</span>
            </div>
        </div>

        <!-- Metric 2 -->
        <div class="bg-white p-5 rounded-2xl border border-amber-200 bg-amber-50/30 shadow-sm space-y-2">
            <div class="flex items-center justify-between text-xs text-amber-900 font-medium">
                <span>عقود شارفت على الانتهاء</span>
                <span class="text-amber-700 font-bold">🟡 أقل من 30 يوم</span>
            </div>
            <div class="text-3xl font-black text-amber-800 font-mono">{{ $currentStats['expiring_soon'] }}</div>
            <div class="text-[11px] text-amber-900 font-semibold">
                <span>⚠️ تتطلب إشعار التجديد الفوري</span>
            </div>
        </div>

        <!-- Metric 3 -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-2">
            <div class="flex items-center justify-between text-xs text-slate-500 font-medium">
                <span>زيارات الفحص المجدولة</span>
                <span class="text-blue-700 font-bold">📅 هذا الأسبوع</span>
            </div>
            <div class="text-3xl font-black text-slate-900 font-mono">{{ $currentStats['pending_visits'] }}</div>
            <div class="text-[11px] text-slate-500 font-semibold">
                <span>منها زيارات طارئة اليوم</span>
            </div>
        </div>

        <!-- Metric 4 -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-2">
            <div class="flex items-center justify-between text-xs text-slate-500 font-medium">
                <span>طلبات الصيانة المفتوحة</span>
                <span class="text-red-700 font-bold">🚨 قيد المعالجة</span>
            </div>
            <div class="text-3xl font-black text-red-600 font-mono">{{ $currentStats['open_tickets'] }}</div>
            <div class="text-[11px] text-slate-500 font-semibold">
                <span>متوسط سرعة الوصول: 35 دقيقة</span>
            </div>
        </div>

    </div>

    <!-- MAIN TWO-COLUMN WORKSPACE -->
    <div class="grid lg:grid-cols-12 gap-6">
        
        <!-- Left 8 Cols (Right in RTL): Contracts & Hierarchy Snapshot -->
        <div class="lg:col-span-8 space-y-6">
            
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                
                <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
                    <div>
                        <h3 class="text-base font-bold text-slate-900">أحدث عقود الصيانة الميدانية (AMC Contracts)</h3>
                        <p class="text-xs text-slate-500">حالة سريان العقود والعداد التنازلي للأيام المتبقية.</p>
                    </div>
                    <a href="{{ route('dashboard.contracts') }}" class="text-xs font-bold text-blue-700 hover:underline">
                        عرض شجرة العقود كاملة ←
                    </a>
                </div>

                <div class="space-y-3">
                    
                    <!-- Contract Item 1 -->
                    <div class="p-4 rounded-xl border border-amber-200 bg-amber-50/20 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <b class="text-sm text-slate-900">مجمع مدارس الأندلس الأهلية</b>
                                <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-amber-100 text-amber-900 border border-amber-300">
                                    🟡 متبقي 25 يومًا
                                </span>
                            </div>
                            <div class="text-xs text-slate-600">
                                <span>الرياض - حي النرجس</span> • 
                                <span>رقم العقد: <b class="font-mono">#NBC-2026-88</b></span> • 
                                <span>القيمة: <b class="font-mono">65,000 ر.س</b></span>
                            </div>
                        </div>
                        <a href="{{ route('dashboard.contracts') }}" class="px-3 py-1.5 bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs rounded-lg text-center">
                            إشعار تجديد
                        </a>
                    </div>

                    <!-- Contract Item 2 -->
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <b class="text-sm text-slate-900">مصنع الخزف والبلاستيك السعودي</b>
                                <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                    🟢 ساري (متبقي 281 يومًا)
                                </span>
                            </div>
                            <div class="text-xs text-slate-600">
                                <span>الدمام - المدينة الصناعية 2</span> • 
                                <span>رقم العقد: <b class="font-mono">#NBC-2026-104</b></span> • 
                                <span>القيمة: <b class="font-mono">120,000 ر.س</b></span>
                            </div>
                        </div>
                        <a href="{{ route('dashboard.contracts') }}" class="px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-lg text-center">
                            تفاصيل العقد
                        </a>
                    </div>

                    <!-- Contract Item 3 -->
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <b class="text-sm text-slate-900">مستودعات أجيليتي اللوجستية المركزية</b>
                                <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                    🟢 ساري (متبقي 190 يومًا)
                                </span>
                            </div>
                            <div class="text-xs text-slate-600">
                                <span>جدة - الخمرة اللوجستية</span> • 
                                <span>رقم العقد: <b class="font-mono">#NBC-2026-119</b></span> • 
                                <span>القيمة: <b class="font-mono">95,000 ر.س</b></span>
                            </div>
                        </div>
                        <a href="{{ route('dashboard.contracts') }}" class="px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-lg text-center">
                            تفاصيل العقد
                        </a>
                    </div>

                </div>

            </div>

        </div>

        <!-- Right 4 Cols: Today's Radar & Fast Actions -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Radar Box -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-sm font-bold text-slate-900">الزيارات الميدانية اليوم</h3>
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                </div>

                <div class="space-y-3 text-xs">
                    <div class="p-3 rounded-xl bg-amber-50 border border-amber-200 space-y-1">
                        <div class="flex justify-between">
                            <b class="text-amber-900">مصنع الخزف (الدمام)</b>
                            <span class="text-[10px] bg-amber-200 text-amber-900 px-1.5 py-0.5 rounded font-bold">جارية الآن</span>
                        </div>
                        <div class="text-slate-600">فحص ضغط مضخات الديزل (م. أحمد القحطاني)</div>
                    </div>

                    <div class="p-3 rounded-xl bg-blue-50 border border-blue-200 space-y-1">
                        <div class="flex justify-between">
                            <b class="text-blue-900">مدارس الأندلس (الرياض)</b>
                            <span class="text-[10px] bg-blue-200 text-blue-900 px-1.5 py-0.5 rounded font-bold">02:00 م</span>
                        </div>
                        <div class="text-slate-600">مسح QR كود لـ 142 طفاية (سالم الدوسري)</div>
                    </div>
                </div>

                <a href="{{ route('dashboard.visits') }}" class="block text-center py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-800 rounded-lg text-xs font-bold transition-colors">
                    فتح جدول الزيارات الكامل ←
                </a>
            </div>

            <!-- Quick Links Box -->
            <div class="bg-slate-900 text-white rounded-2xl p-6 shadow-sm space-y-4">
                <h3 class="text-sm font-bold">اختصارات سريعة</h3>
                <div class="space-y-2 text-xs">
                    <a href="{{ route('dashboard.internal_requests') }}" class="flex items-center justify-between p-2.5 rounded-lg bg-slate-800 hover:bg-slate-700 transition-colors">
                        <span>🔄 طلبات الصيانة بين الإدارات</span>
                        <span>←</span>
                    </a>
                    <a href="{{ route('dashboard.reports') }}" class="flex items-center justify-between p-2.5 rounded-lg bg-slate-800 hover:bg-slate-700 transition-colors">
                        <span>📝 نماذج وتقارير الفحص الميداني</span>
                        <span>←</span>
                    </a>
                    <a href="{{ route('dashboard.permissions') }}" class="flex items-center justify-between p-2.5 rounded-lg bg-slate-800 hover:bg-slate-700 transition-colors">
                        <span>⚙️ إدارة الصلاحيات والأدوار</span>
                        <span>←</span>
                    </a>
                </div>
            </div>

        </div>

    </div>

@endsection
