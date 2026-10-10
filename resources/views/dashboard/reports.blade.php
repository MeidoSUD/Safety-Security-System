@extends('layouts.dashboard')

@section('title', 'تقارير ونماذج الفحص الميداني | نبيكو ERP')
@section('page_title', 'إدارة التقارير الفنية المعتمدة، نماذج الفحص، وشهادات الامتثال')

@section('content')

    <!-- TOP HEADER -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                <span>📝 منظومة التقارير الفنية المعتمدة (Safety Inspection Reports)</span>
                <span class="text-xs px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-semibold">كود SBC 801</span>
            </h2>
            <p class="text-xs text-slate-500 mt-0.5">
                إصدار تقارير الفحص الفني، مطابقة الدفاع المدني، واعتماد الشهادات للمنشآت والمواقع الميدانية.
            </p>
        </div>

        <a href="{{ route('dashboard.visits') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow transition-colors flex items-center gap-1.5 shrink-0">
            <span>👷</span>
            <span>الانتقال لزيارات الفحص لتعبئة تقرير</span>
        </a>
    </div>

    <!-- 1. ISSUED TECHNICAL REPORTS LIST -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm mb-6 space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                <span>📄</span>
                <span>التقارير وشهادات الفحص الصادرة ({{ $reports->count() }})</span>
            </h3>
        </div>

        <div class="space-y-3">
            @forelse($reports as $rep)
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white hover:border-blue-300 transition-all flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    
                    <div class="space-y-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="font-mono text-xs font-bold text-slate-700 bg-slate-200 px-2 py-0.5 rounded">#{{ $rep->report_number }}</span>
                            <b class="text-slate-900 text-sm">{{ $rep->visit->facility->name ?? 'موقع' }}</b>
                            
                            @if($rep->status === 'approved')
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                    معتمد رسمياً ✓
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-900 border border-amber-300">
                                    بانتظار الاعتماد
                                </span>
                            @endif

                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-700">
                                {{ $rep->overall_status_arabic }}
                            </span>
                        </div>

                        <p class="text-xs text-slate-600 line-clamp-1 pr-1">{{ $rep->summary }}</p>

                        <div class="flex flex-wrap items-center gap-3 text-[11px] text-slate-500 pt-1">
                            <span>المهندس الفاحص: <b>{{ $rep->engineer->name ?? $rep->visit->engineer->name }}</b></span>
                            <span>•</span>
                            <span>رقم الزيارة: <b class="font-mono text-slate-700">#{{ $rep->visit->visit_number }}</b></span>
                            <span>•</span>
                            <span>تاريخ الفحص: <b class="font-mono">{{ $rep->created_at->format('Y-m-d') }}</b></span>
                        </div>
                    </div>

                    <div class="shrink-0 flex items-center gap-2">
                        <a href="{{ route('dashboard.reports.show', $rep->id) }}" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold shadow transition-colors flex items-center gap-1.5">
                            <span>🖨️</span>
                            <span>معاينة وطباعة الشهادة</span>
                        </a>
                    </div>

                </div>
            @empty
                <div class="text-center py-8 text-xs text-slate-400">
                    لم يتم إصدار أي تقارير فحص بعد.
                </div>
            @endforelse
        </div>
    </div>

    <!-- 2. INSPECTION TEMPLATES OVERVIEW -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div>
                <b class="text-sm text-slate-900">2. نماذج واستمارات الفحص المعتمدة لكود البناء السعودي SBC 801</b>
                <p class="text-xs text-slate-500">نماذج فحص قياسية تستخدم ميدانياً عبر الجوال أو التابلت.</p>
            </div>
            <span class="text-xs font-mono font-bold text-slate-700 bg-slate-100 px-2.5 py-1 rounded">4 نماذج قياسية</span>
        </div>

        <div class="grid md:grid-cols-2 gap-4 text-xs">
            <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 space-y-2">
                <div class="flex items-center justify-between">
                    <b class="text-slate-900">نموذج فحص مضخات الحريق وشبكة الضغط (PSI/Bar)</b>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">نشط ✓</span>
                </div>
                <p class="text-slate-500 text-[11px]">اختبار ضغط الإغلاق (Churn Pressure)، مضخة الجوكي، وفلاتر الديزل.</p>
            </div>

            <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 space-y-2">
                <div class="flex items-center justify-between">
                    <b class="text-slate-900">نموذج فحص شبكة إنذار الحريق المعنونة (Fire Alarm Loop)</b>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">نشط ✓</span>
                </div>
                <p class="text-slate-500 text-[11px]">اختبار الكواشف، البطاريات الاحتياطية، والأجراس وكاسرات الزجاج.</p>
            </div>

            <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 space-y-2">
                <div class="flex items-center justify-between">
                    <b class="text-slate-900">نموذج فحص شبكات الرش الآلي وصمامات زون (Sprinklers)</b>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">نشط ✓</span>
                </div>
                <p class="text-slate-500 text-[11px]">صمامات الفحص Flow Switch والمحابس الإشرافية ووصلات سيامي.</p>
            </div>

            <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 space-y-2">
                <div class="flex items-center justify-between">
                    <b class="text-slate-900">نموذج فحص طفايات الحريق اليدوية ومخارج الطوارئ</b>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">نشط ✓</span>
                </div>
                <p class="text-slate-500 text-[11px]">تعبئة بودرة وبطاقات الفحص وصلاحية كبسولات ثاني أكسيد الكربون.</p>
            </div>
        </div>
    </div>

@endsection
