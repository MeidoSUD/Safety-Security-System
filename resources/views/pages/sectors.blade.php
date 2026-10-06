@extends('layouts.app')

@section('title', 'حلول المدارس والمصانع | درع السلامة')

@section('content')

    <!-- Header Banner -->
    <section class="bg-white border-b border-slate-200 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">القطاعات المتخصصة (المدارس والمصانع)</h1>
            <p class="text-sm text-slate-600 mt-2 max-w-2xl">
                نقدم اشتراطات السلامة الدقيقة وحلول العقود المصممة خصيصاً للمنشآت التعليمية والصناعية الكبرى بالمملكة.
            </p>
        </div>
    </section>

    <!-- Sectors Breakdown -->
    <section class="py-12 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            
            <!-- Sector 1: Schools -->
            <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm">
                <div class="max-w-3xl space-y-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-blue-50 text-blue-700 text-xs font-bold rounded-md">
                        <span>🎓 القطاع التعليمي</span>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900">سلامة المدارس الأهلية، العالمية والجامعات</h2>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        توفر الشركة باقة متكاملة للمدارس تشمل الصيانة الدورية الشاملة لكواشف الدخان في الفصول، حساسات الغاز في المختبرات العلمية، فحص مضخات الحريق، وتدريب الهيئة التعليمية والطلاب على خطط الإخلاء الافتراضية.
                    </p>

                    <div class="grid sm:grid-cols-2 gap-4 pt-4 text-xs text-slate-700">
                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                            <b class="text-slate-900 block mb-1">✓ مطابقة اشتراطات وزارة التعليم</b>
                            <span>إصدار وتجديد التقارير الهندسية المطلوبة لترخيص المنشأة التعليمية سنوياً.</span>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                            <b class="text-slate-900 block mb-1">✓ أنظمة إخلاء وتنبيه صوتي</b>
                            <span>أنظمة إذاعة طوارئ مركزية لإرشاد الطلاب نحو المخارج الآمنة ونقاط التجمع.</span>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                            <b class="text-slate-900 block mb-1">✓ أمان المعامل والمطابخ</b>
                            <span>كواشف تسريب غاز وأنظمة إطفاء تلقائية للمقاصف ومختبرات الكيمياء.</span>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                            <b class="text-slate-900 block mb-1">✓ شهادات صيانة رقمية فورية</b>
                            <span>تحميل تقارير الفحص عبر بوابة العميل وربطها المباشر بمنصة سلامة.</span>
                        </div>
                    </div>

                    <div class="pt-4">
                        <a href="{{ route('membership') }}" class="inline-block px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-lg transition-colors">
                            طلب عقد صيانة لمدرسة أو مجمع تعليمي
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sector 2: Factories & Industrial Complexes -->
            <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm">
                <div class="max-w-3xl space-y-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-amber-50 text-amber-700 text-xs font-bold rounded-md">
                        <span>🏭 القطاع الصناعي والمستودعات</span>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900">سلامة المصانع، المستودعات، والمدن الصناعية (مدن)</h2>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        تتطلب البيئات الصناعية درجات حماية قصوى للتعامل مع المواد القابلة للاشتعال، خطوط الإنتاج، والارتفاعات العالية في المستودعات. نوفر شبكات إطفاء متطورة برغوة الفوم وغازات FM200 وCO2 مع مضخات ديزل صناعية.
                    </p>

                    <div class="grid sm:grid-cols-2 gap-4 pt-4 text-xs text-slate-700">
                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                            <b class="text-slate-900 block mb-1">✓ أنظمة إطفاء بالغازات النظيفة</b>
                            <span>حماية غرف السيرفرات، لوحات التوزيع الكهربائية الرئيسية، ومحطات المولدات.</span>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                            <b class="text-slate-900 block mb-1">✓ كواشف لهب واستشعار حراري</b>
                            <span>كواشف بالأشعة فوق البنفسجية وتحت الحمراء (UV/IR) للكشف الفوري عن أي شرارة.</span>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                            <b class="text-slate-900 block mb-1">✓ مطابقة معايير مدن والدفاع المدني</b>
                            <span>إصدار شهادات الإنجاز الفني المعتمدة لدى الهيئة السعودية للمدن الصناعية.</span>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                            <b class="text-slate-900 block mb-1">✓ صيانة شبكات الهيدرنت ومضخات الديزل</b>
                            <span>اختبار أسبوعي وشهري لمضخات الطوارئ والتأكد من ضغط المياه عبر حساسات رقمية.</span>
                        </div>
                    </div>

                    <div class="pt-4">
                        <a href="{{ route('membership') }}" class="inline-block px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-lg transition-colors">
                            طلب عقد صيانة لمصنع أو مستودع
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection
