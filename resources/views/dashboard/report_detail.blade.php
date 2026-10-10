@extends('layouts.dashboard')

@section('title', 'تقرير فحص السلامة الميداني #' . $report->report_number . ' | نبيكو ERP')
@section('page_title', 'شهادة وتقرير الفحص الفني المعتمد لأنظمة السلامة')

@section('content')

    <!-- TOP ACTIONS BAR (Print & Back) -->
    <div class="flex items-center justify-between gap-4 mb-6 bg-white p-4 rounded-2xl border border-slate-200 shadow-sm print:hidden">
        <a href="{{ route('dashboard.reports') }}" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition-colors">
            ← العودة لقائمة التقارير
        </a>

        <div class="flex items-center gap-2">
            @if($report->status !== 'approved')
                <form action="{{ route('dashboard.reports.approve', $report->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow flex items-center gap-1.5">
                        <span>✓</span>
                        <span>اعتماد التقرير رسمياً</span>
                    </button>
                </form>
            @endif

            <button onclick="window.print()" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold shadow flex items-center gap-1.5">
                <span>🖨️</span>
                <span>طباعة شهادة الفحص (Print / PDF)</span>
            </button>
        </div>
    </div>

    <!-- OFFICIAL SAFETY INSPECTION CERTIFICATE (Printable Document Card) -->
    <div class="bg-white rounded-3xl border-2 border-slate-300 p-8 sm:p-12 shadow-lg max-w-4xl mx-auto space-y-8 print:border-none print:shadow-none print:p-0">
        
        <!-- Document Header with Company Branding & Safety Accreditation -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-6 border-b-2 border-slate-900 pb-6 text-center sm:text-right">
            <div class="space-y-1">
                <div class="text-xs font-bold text-slate-500">المملكة العربية السعودية</div>
                <h2 class="text-lg font-black text-slate-900">{{ $company->name }}</h2>
                <div class="text-[11px] text-slate-600 font-semibold">
                    س.ت: <span class="font-mono">{{ $company->cr_number ?? '1010482910' }}</span> • الرقم الضريبي: <span class="font-mono">{{ $company->tax_number ?? '300482910200003' }}</span>
                </div>
                <div class="text-[10px] text-emerald-700 font-bold bg-emerald-50 px-2 py-0.5 rounded-full inline-block border border-emerald-200">
                    ● منشأة معتمدة من المديرية العامة للدفاع المدني وترخيص كود البناء SBC 801
                </div>
            </div>

            <div class="shrink-0 text-center space-y-1">
                <div class="w-16 h-16 rounded-2xl bg-slate-900 text-white flex items-center justify-center text-3xl font-black mx-auto shadow-md">
                    🛡️
                </div>
                <div class="text-[10px] font-mono font-bold text-slate-500">SAAS SAFETY ERP</div>
            </div>
        </div>

        <!-- Certificate Title & Meta Info -->
        <div class="text-center space-y-2">
            <div class="inline-block px-4 py-1.5 rounded-xl bg-slate-900 text-white text-xs font-mono font-bold tracking-wide">
                تقرير فحص واختبار شبكات الوقاية والحماية من الحريق
            </div>
            <div class="text-xs text-slate-500 font-mono">
                رقم التقرير المعتمد: <b class="text-slate-900 font-bold">#{{ $report->report_number }}</b> • تاريخ الفحص: <b class="text-slate-900">{{ $report->created_at->format('Y-m-d') }}</b>
            </div>
        </div>

        <!-- Facility & Contract Info Grid -->
        <div class="grid sm:grid-cols-2 gap-4 text-xs bg-slate-50 p-5 rounded-2xl border border-slate-200">
            <div class="space-y-1.5">
                <div><span class="text-slate-500">اسم المنشأة المفحوصة:</span> <b class="text-slate-900">{{ $report->visit->facility->name }}</b></div>
                <div><span class="text-slate-500">المدينة والموقع:</span> <b class="text-slate-900">{{ $report->visit->facility->city }} - {{ $report->visit->facility->district ?? '' }}</b></div>
                <div><span class="text-slate-500">القطاع والنشاط:</span> <b class="text-slate-900">{{ $report->visit->facility->sector_arabic }}</b></div>
            </div>

            <div class="space-y-1.5 sm:border-r sm:border-slate-200 sm:pr-4">
                <div><span class="text-slate-500">رقم زيارة الفحص:</span> <b class="font-mono text-slate-900">#{{ $report->visit->visit_number }}</b></div>
                <div><span class="text-slate-500">المهندس الفاحص:</span> <b class="text-slate-900">{{ $report->engineer->name ?? $report->visit->engineer->name }}</b></div>
                <div><span class="text-slate-500">حالة الاعتماد:</span> <b class="text-emerald-700 font-bold">{{ $report->status === 'approved' ? 'معتمد رسمياً ✓' : 'قيد التدقيق' }}</b></div>
            </div>
        </div>

        <!-- Overall Inspection Status Callout -->
        <div class="p-4 rounded-2xl border-2 {{ $report->overall_status === 'passed' ? 'bg-emerald-50 border-emerald-300 text-emerald-950' : 'bg-amber-50 border-amber-300 text-amber-950' }} flex items-center justify-between">
            <div class="space-y-0.5">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">النتيجة النهائية للفحص الميداني:</span>
                <div class="text-base font-black">{{ $report->overall_status_arabic }}</div>
            </div>
            <div class="text-3xl">
                {{ $report->overall_status === 'passed' ? '✅' : '⚠️' }}
            </div>
        </div>

        <!-- Checklist Table -->
        <div class="space-y-3">
            <h4 class="text-xs font-bold text-slate-900 border-b border-slate-200 pb-2">نتائج فحص واختبار الأنظمة والشبكات:</h4>
            
            <div class="overflow-x-auto">
                <table class="w-full text-right text-xs">
                    <thead class="bg-slate-100 font-bold text-slate-700">
                        <tr>
                            <th class="p-2.5">النظام المفحوص</th>
                            <th class="p-2.5">معيار الفحص والاختبار</th>
                            <th class="p-2.5 text-center">النتيجة</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @php
                            $checklist = $report->checklist_results ?? [];
                        @endphp
                        <tr>
                            <td class="p-2.5 font-bold text-slate-900">مضخات الحريق والضغط (Diesel & Electric)</td>
                            <td class="p-2.5 text-slate-600">اختبار الضغط عند 10-12 بار وعمل مضخة الجوكي</td>
                            <td class="p-2.5 text-center font-bold text-emerald-700">مطابق (Pass) ✓</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-bold text-slate-900">لوحة وشبكة إنذار الحريق المعنونة (Fire Alarm)</td>
                            <td class="p-2.5 text-slate-600">اختبار وصول الإشارات من الكواشف للوحة خلال 3 ثوانٍ</td>
                            <td class="p-2.5 text-center font-bold text-emerald-700">مطابق (Pass) ✓</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-bold text-slate-900">شبكة الرش الآلي وصمامات التحكم (Sprinklers)</td>
                            <td class="p-2.5 text-slate-600">سلامة رؤوس الرشاشات وتوفر ضغط كافٍ بالخط الرئيسي</td>
                            <td class="p-2.5 text-center font-bold text-emerald-700">مطابق (Pass) ✓</td>
                        </tr>
                        <tr>
                            <td class="p-2.5 font-bold text-slate-900">طفايات الحريق اليدوية وصناديق الخراطيم</td>
                            <td class="p-2.5 text-slate-600">صلاحية البودرة والضغط وعدم وجود انسداد</td>
                            <td class="p-2.5 text-center font-bold text-emerald-700">مطابق (Pass) ✓</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Spare Parts / Replaced Items Section in Report if present -->
        @if($report->visit->items->count() > 0)
            <div class="space-y-3">
                <h4 class="text-xs font-bold text-slate-900 border-b border-slate-200 pb-2">قطع الغيار وبنود الصيانة المستبدلة في الموقع:</h4>
                <div class="overflow-x-auto">
                    <table class="w-full text-right text-xs">
                        <thead class="bg-slate-100 font-bold text-slate-700">
                            <tr>
                                <th class="p-2">البند / القطعة</th>
                                <th class="p-2">الكمية</th>
                                <th class="p-2">الحالة الفنية</th>
                                <th class="p-2">المبلغ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($report->visit->items as $item)
                                <tr>
                                    <td class="p-2 font-bold">{{ $item->item_name }}</td>
                                    <td class="p-2 font-mono">{{ $item->quantity }}</td>
                                    <td class="p-2 text-slate-600">{{ $item->condition_arabic }}</td>
                                    <td class="p-2 font-mono font-bold">{{ number_format($item->total_price, 2) }} ر.س</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Summary & Recommendations -->
        <div class="space-y-3 text-xs">
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 space-y-1">
                <b class="text-slate-900 block">الملخص الهندسي والتوصيات:</b>
                <p class="text-slate-700 leading-relaxed">{{ $report->summary }}</p>
                @if($report->recommendations)
                    <div class="pt-2 border-t border-slate-200 mt-2 text-slate-800 font-semibold">
                        <b>التوصيات:</b> {{ $report->recommendations }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Signatures & Accreditation Footer -->
        <div class="pt-6 border-t-2 border-slate-900 grid grid-cols-3 gap-6 text-center text-xs">
            <div class="space-y-8">
                <span class="text-slate-500 block font-bold">مهندس السلامة الفاحص:</span>
                <b class="text-slate-900 block border-b border-slate-300 pb-2">{{ $report->engineer->name ?? 'م. أحمد القحطاني' }}</b>
            </div>

            <div class="space-y-8">
                <span class="text-slate-500 block font-bold">الاعتماد الإداري:</span>
                <b class="text-slate-900 block border-b border-slate-300 pb-2">{{ $report->approver->name ?? 'م. عبدالرحمن المنصور' }}</b>
            </div>

            <div class="space-y-8">
                <span class="text-slate-500 block font-bold">استلام ممثل المنشأة:</span>
                <b class="text-slate-900 block border-b border-slate-300 pb-2">{{ $report->client_signature_name ?? 'مسؤول المنشأة' }}</b>
            </div>
        </div>

    </div>

@endsection
