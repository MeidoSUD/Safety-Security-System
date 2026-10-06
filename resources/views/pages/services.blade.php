@extends('layouts.app')

@section('title', 'خدمات الأمن والسلامة | درع السلامة')

@section('content')

    <!-- Header Banner -->
    <section class="bg-white border-b border-slate-200 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">خدمات الأمن والسلامة المعتمدة</h1>
            <p class="text-sm text-slate-600 mt-2 max-w-2xl">
                نقدم باقة متكاملة من الخدمات الهندسية والفنية المعتمدة من الدفاع المدني السعودي للمباني التعليمية، الصناعية، والتجارية.
            </p>
        </div>
    </section>

    <!-- Services Grid -->
    <section class="py-12 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- Service 1 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <div class="w-10 h-10 rounded-lg bg-red-50 text-red-600 flex items-center justify-center font-bold text-lg">
                        🚒
                    </div>
                    <h2 class="text-lg font-bold text-slate-900">أنظمة مكافحة وإطفاء الحريق</h2>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        توريد، تركيب واختبار شبكات الرش الآلي (Sprinklers)، مضخات الحريق الرئيسية والجوكي، شبكات الهيدرنت، وأنظمة الإطفاء الغازي النظيف (FM-200 / Novec 1230 / CO2).
                    </p>
                    <ul class="text-xs text-slate-500 space-y-1.5 pt-2 border-t border-slate-100">
                        <li>• مضخات حريق معتمدة UL/FM</li>
                        <li>• شبكات الرش الآلي الجاف والرطب</li>
                        <li>• أنظمة إطفاء غرف الكهرباء والسيرفرات</li>
                    </ul>
                </div>

                <!-- Service 2 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-lg">
                        🔔
                    </div>
                    <h2 class="text-lg font-bold text-slate-900">أنظمة الإنذار والكشف المبكر</h2>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        لوحات الإنذار المعنونة (Addressable) والتقليدية، كواشف الدخان والحرارة والغاز، كواشف الشعاع الضوئي (Beam Detectors) للصالات والمستودعات المرتفعة، وكاسرات الإنذار الزجاجية.
                    </p>
                    <ul class="text-xs text-slate-500 space-y-1.5 pt-2 border-t border-slate-100">
                        <li>• لوحات إنذار مركزية ذكية</li>
                        <li>• كواشف ليزرية للمستودعات والمصانع</li>
                        <li>• أجهزة إنذار صوتي وضوئي مدمجة</li>
                    </ul>
                </div>

                <!-- Service 3 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-lg">
                        📑
                    </div>
                    <h2 class="text-lg font-bold text-slate-900">عقود الصيانة السنوية (AMC)</h2>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        عقود صيانة دورية (سنوية وربع سنوية) معتمدة رسمياً لدى الدفاع المدني ومنصة سلامة، تضمن الجاهزية التامة لجميع معدات السلامة وتجنب الغرامات النظامية.
                    </p>
                    <ul class="text-xs text-slate-500 space-y-1.5 pt-2 border-t border-slate-100">
                        <li>• زيارات فحص ربع سنوية مجدولة</li>
                        <li>• إصدار شهادات الصيانة الرقمية فورياً</li>
                        <li>• فرق طوارئ واستجابة على مدار الساعة</li>
                    </ul>
                </div>

                <!-- Service 4 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-lg">
                        🏛️
                    </div>
                    <h2 class="text-lg font-bold text-slate-900">إصدار وتجديد تراخيص سلامة</h2>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        استخراج التقارير الفنية المعتمدة للسلامة ورفعها على منصة سلامة لإصدار أو تجديد رخص الدفاع المدني وربطها برخص البلدية الفورية (بلدي).
                    </p>
                    <ul class="text-xs text-slate-500 space-y-1.5 pt-2 border-t border-slate-100">
                        <li>• مطابقة متطلبات كود البناء السعودي SBC</li>
                        <li>• إنجاز وتجديد الرخص خلال 24-48 ساعة</li>
                        <li>• شهادات إنجاز تركيبات معتمدة</li>
                    </ul>
                </div>

                <!-- Service 5 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <div class="w-10 h-10 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center font-bold text-lg">
                        📐
                    </div>
                    <h2 class="text-lg font-bold text-slate-900">المخططات الهندسية والاستشارات</h2>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        إعداد واعتماد مخططات السلامة الهندسية (Safety Blueprints)، الحسابات الهيدروليكية، دراسات تقييم المخاطر، وتصميم مسارات وخطط الإخلاء المعتمدة.
                    </p>
                    <ul class="text-xs text-slate-500 space-y-1.5 pt-2 border-t border-slate-100">
                        <li>• مخططات أوتوكاد معتمدة</li>
                        <li>• حسابات التدفق الهيدروليكي للمضخات</li>
                        <li>• لوحات إرشادات ومسارات الهروب</li>
                    </ul>
                </div>

                <!-- Service 6 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <div class="w-10 h-10 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center font-bold text-lg">
                        📹
                    </div>
                    <h2 class="text-lg font-bold text-slate-900">كاميرات المراقبة والتحكم بالدخول</h2>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        توريد وتركيب كاميرات المراقبة الأمنية IP المعتمدة لدى الضبط الإداري، أنظمة التحكم بالأبواب ومخارج الطوارئ المغناطيسية، ومعدات السلامة المهنية.
                    </p>
                    <ul class="text-xs text-slate-500 space-y-1.5 pt-2 border-t border-slate-100">
                        <li>• كاميرات IP فائقة الدقة للمصانع والمدارس</li>
                        <li>• أقفال طوارئ كهرومغناطيسية للمخارج</li>
                        <li>• أنظمة نداء وإخلاء صوتي مركزي</li>
                    </ul>
                </div>

            </div>

            <!-- Bottom CTA -->
            <div class="mt-12 bg-white p-8 rounded-2xl border border-slate-200 text-center max-w-2xl mx-auto space-y-4">
                <h3 class="text-lg font-bold text-slate-900">هل تحتاج إلى عرض سعر مخصص لمنشأتك؟</h3>
                <p class="text-xs text-slate-600">
                    يقوم فريقنا الهندسي بدراسة متطلبات منشأتك وتقديم عرض سعر وعقد صيانة دوري معتمد فورياً.
                </p>
                <div class="pt-2">
                    <a href="{{ route('membership') }}" class="inline-block px-6 py-2.5 rounded-lg text-xs font-bold text-white bg-slate-900 hover:bg-slate-800 transition-colors">
                        طلب عرض سعر / فتح ملف منشأة
                    </a>
                </div>
            </div>

        </div>
    </section>

@endsection
