@extends('layouts.app')

@section('title', 'الرئيسية | درع السلامة لأنظمة مكافحة الحريق والحلول الميدانية')

@section('content')

    <!-- Clean Minimal Hero -->
    <section class="bg-white border-b border-slate-200 py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                
                <!-- Simple Badge -->
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-slate-100 border border-slate-200 text-xs font-semibold text-slate-700 mb-6">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>معتمد رسمياً من الدفاع المدني ومنصة سلامة 🇸🇦</span>
                </div>

                <!-- Main Title -->
                <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight mb-6">
                    حلول الأمن والسلامة ومكافحة الحريق المتكاملة للمنشآت في المملكة
                </h1>

                <!-- Subtitle -->
                <p class="text-base sm:text-lg text-slate-600 leading-relaxed mb-8">
                    نقدم خدمات توريد، تركيب وصيانة شبكات الإنذار والإطفاء، إصدار وتجديد رخص الدفاع المدني، وإدارة العقود الميدانية عبر منظومة ERP متطورة للمدارس والمصانع.
                </p>

                <!-- Actions -->
                <div class="flex flex-wrap items-center gap-4">
                    <a href="{{ route('membership') }}" class="px-6 py-3 rounded-lg text-sm font-bold text-white bg-slate-900 hover:bg-slate-800 transition-colors shadow-sm">
                        طلب عضوية أو فتح ملف منشأة
                    </a>

                    <a href="{{ route('services') }}" class="px-6 py-3 rounded-lg text-sm font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                        استعراض الخدمات
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- Key Numbers (Simple & Clean) -->
    <section class="bg-slate-50 border-b border-slate-200 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div class="p-4">
                    <div class="text-3xl font-extrabold text-slate-900 font-mono">+1,200</div>
                    <div class="text-xs text-slate-600 font-medium mt-1">مدرسة ومصنع تحت إشرافنا</div>
                </div>
                <div class="p-4">
                    <div class="text-3xl font-extrabold text-slate-900 font-mono">100%</div>
                    <div class="text-xs text-slate-600 font-medium mt-1">نسبة اجتياز تفتيش الدفاع المدني</div>
                </div>
                <div class="p-4">
                    <div class="text-3xl font-extrabold text-slate-900 font-mono">24/7</div>
                    <div class="text-xs text-slate-600 font-medium mt-1">فرق طوارئ واستجابة سريعة</div>
                </div>
                <div class="p-4">
                    <div class="text-3xl font-extrabold text-slate-900 font-mono">+45</div>
                    <div class="text-xs text-slate-600 font-medium mt-1">مهندس ومشرف ميداني معتمد</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Services Overview (4 Simple Clean Cards) -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900">خدمات السلامة الأساسية</h2>
                    <p class="text-sm text-slate-500 mt-1">خدمات هندسية وفنية معتمدة تلبي اشتراطات كود البناء السعودي</p>
                </div>
                <a href="{{ route('services') }}" class="text-sm font-bold text-slate-900 hover:underline mt-4 md:mt-0">
                    عرض جميع الخدمات ←
                </a>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <div class="p-6 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white hover:shadow-md transition-all">
                    <div class="w-10 h-10 rounded-lg bg-red-100 text-red-600 flex items-center justify-center font-bold mb-4">
                        🚒
                    </div>
                    <h3 class="font-bold text-slate-900 mb-2">مكافحة وإطفاء الحريق</h3>
                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        تركيب وصيانة شبكات الرش الآلي، مضخات الحريق، وأنظمة الغاز النظيف FM200 وCO2.
                    </p>
                    <a href="{{ route('services') }}" class="text-xs font-semibold text-slate-900 hover:underline">المزيد من التفاصيل ←</a>
                </div>

                <div class="p-6 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white hover:shadow-md transition-all">
                    <div class="w-10 h-10 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center font-bold mb-4">
                        🔔
                    </div>
                    <h3 class="font-bold text-slate-900 mb-2">أنظمة الإنذار المبكر</h3>
                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        لوحات الإنذار المعنونة وكواشف الدخان والحرارة والغاز المعتمدة لدى الدفاع المدني.
                    </p>
                    <a href="{{ route('services') }}" class="text-xs font-semibold text-slate-900 hover:underline">المزيد من التفاصيل ←</a>
                </div>

                <div class="p-6 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white hover:shadow-md transition-all">
                    <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold mb-4">
                        📑
                    </div>
                    <h3 class="font-bold text-slate-900 mb-2">عقود الصيانة الدورية AMC</h3>
                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        عقود صيانة سنوية وربع سنوية معتمدة ورفع التقارير مباشرة على منصة سلامة.
                    </p>
                    <a href="{{ route('services') }}" class="text-xs font-semibold text-slate-900 hover:underline">المزيد من التفاصيل ←</a>
                </div>

                <div class="p-6 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white hover:shadow-md transition-all">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center font-bold mb-4">
                        🏛️
                    </div>
                    <h3 class="font-bold text-slate-900 mb-2">رخص منصة سلامة</h3>
                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        إصدار وتجديد تراخيص الدفاع المدني والشهادات الفنية اللازمة لرخص البلدية.
                    </p>
                    <a href="{{ route('services') }}" class="text-xs font-semibold text-slate-900 hover:underline">المزيد من التفاصيل ←</a>
                </div>

            </div>

        </div>
    </section>

    <!-- Dedicated Section: Schools & Factories -->
    <section class="py-16 bg-slate-100 border-y border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                
                <!-- School Card -->
                <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <span class="text-xs font-bold text-blue-700 bg-blue-50 px-2.5 py-1 rounded">القطاع التعليمي</span>
                    <h3 class="text-xl font-bold text-slate-900">حلول سلامة المدارس والمجمعات التعليمية</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        حماية الفصول والمعامل، خطط إخلاء ذكية، وصيانة دورية مطابقة لمتطلبات وزارة التعليم والدفاع المدني.
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('sectors') }}" class="text-xs font-bold text-slate-900 hover:underline">استعراض حلول المدارس ←</a>
                    </div>
                </div>

                <!-- Factory Card -->
                <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <span class="text-xs font-bold text-amber-700 bg-amber-50 px-2.5 py-1 rounded">القطاع الصناعي</span>
                    <h3 class="text-xl font-bold text-slate-900">حلول سلامة المصانع والمستودعات الكبرى</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        أنظمة إطفاء بالغازات ورغوة الفوم للمواد الخطرة، وشبكات مضخات ديزل مطابقة لمعايير مدن (MODON).
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('sectors') }}" class="text-xs font-bold text-slate-900 hover:underline">استعراض حلول المصانع ←</a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Clean ERP Teaser -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-3xl">
            <h2 class="text-2xl font-bold text-slate-900 mb-3">منظومة ERP لإدارة السلامة الميدانية</h2>
            <p class="text-sm text-slate-600 mb-8 leading-relaxed">
                نظام رقمي يربط المالك، المدير العام، مهندس الموقع، المشرف الميداني، والعملاء (المدارس والمصانع) في شاشة واحدة لمتابعة العقود والفحوصات الدورية.
            </p>
            <div class="flex justify-center gap-4">
                <a href="{{ route('erp') }}" class="px-5 py-2.5 rounded-lg text-xs font-bold text-white bg-slate-900 hover:bg-slate-800 transition-colors">
                    تعرف على أدوار النظام
                </a>
                <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-lg text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                    تجربة تسجيل الدخول
                </a>
            </div>
        </div>
    </section>

@endsection
