@extends('layouts.app')

@section('title', 'نظام ERP لإدارة السلامة | درع السلامة')

@section('content')

    <!-- Header Banner -->
    <section class="bg-white border-b border-slate-200 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">منظومة ERP لإدارة السلامة الميدانية</h1>
            <p class="text-sm text-slate-600 mt-2 max-w-2xl">
                برنامج سحابي متكامل يربط إدارة الشركة الهندسية، المهندسين الميدانيين، والمشرفين مع العملاء لضمان التوثيق الدقيق والفحص الفوري.
            </p>
        </div>
    </section>

    <!-- ERP Roles Section (Clean & Distinct) -->
    <section class="py-12 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- Role 1: Owner -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3">
                    <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center font-bold text-lg">
                        👑
                    </div>
                    <span class="text-[11px] font-bold text-amber-700 uppercase">الإدارة العليا</span>
                    <h3 class="text-base font-bold text-slate-900">مالك الشركة (Owner)</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        متابعة حجم العقود السارية، التقارير المالية والتحصيل، مؤشرات نمو العملاء في المدارس والمصانع، ونسب الالتزام بمواعيد الفحص الدوري.
                    </p>
                    <div class="pt-2 border-t border-slate-100 text-xs text-slate-500">
                        • لوحة مؤشرات الأداء اللحظية<br>
                        • تقارير الإيرادات وعقود الـ AMC
                    </div>
                </div>

                <!-- Role 2: General Manager -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3">
                    <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center font-bold text-lg">
                        🏢
                    </div>
                    <span class="text-[11px] font-bold text-blue-700 uppercase">الإدارة التشغيلية</span>
                    <h3 class="text-base font-bold text-slate-900">المدير العام (General Manager)</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        توزيع مهام الزيارات الميدانية على المهندسين، اعتماد المخططات الهندسية والتقارير الفنية قبل رفعها على منصة سلامة، ومراقبة جودة الخدمة.
                    </p>
                    <div class="pt-2 border-t border-slate-100 text-xs text-slate-500">
                        • جدولة الزيارات والمشاريع<br>
                        • اعتماد تقارير الفحص والشهادات
                    </div>
                </div>

                <!-- Role 3: Site Engineer -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3">
                    <div class="w-10 h-10 rounded-lg bg-orange-50 text-orange-700 flex items-center justify-center font-bold text-lg">
                        👷
                    </div>
                    <span class="text-[11px] font-bold text-orange-700 uppercase">العمليات الفنية</span>
                    <h3 class="text-base font-bold text-slate-900">مهندس الموقع (Site Engineer)</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        تطبيق ميداني لتسجيل قراءات ضغط مضخات الحريق وشبكات الرش، اختبار لوحات الإنذار، وتوليد استمارة الفحص الرقمية المعتمدة فور انتهاء المعاينة.
                    </p>
                    <div class="pt-2 border-t border-slate-100 text-xs text-slate-500">
                        • تسجيل قراءات الضغط (PSI)<br>
                        • رفع صور الملاحظات الهندسية
                    </div>
                </div>

                <!-- Role 4: Field Supervisor -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3">
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold text-lg">
                        🛡️
                    </div>
                    <span class="text-[11px] font-bold text-emerald-700 uppercase">الإشراف الميداني</span>
                    <h3 class="text-base font-bold text-slate-900">المشرف الميداني (Supervisor)</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        مسح سريع لأكواد QR Code على طفايات الحريق وصناديق الخراطيم، توثيق الحضور الجغرافي (GPS Check-in)، وفتح تذاكر الصيانة الطارئة للأعطال.
                    </p>
                    <div class="pt-2 border-t border-slate-100 text-xs text-slate-500">
                        • مسح باركود الطفايات والصناديق<br>
                        • توثيق التفتيش بموقع العميل
                    </div>
                </div>

                <!-- Role 5: Clients (Schools & Factories) -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3 md:col-span-2 lg:col-span-2">
                    <div class="w-10 h-10 rounded-lg bg-rose-50 text-rose-700 flex items-center justify-center font-bold text-lg">
                        🏫
                    </div>
                    <span class="text-[11px] font-bold text-rose-700 uppercase">بوابة العميل</span>
                    <h3 class="text-base font-bold text-slate-900">العملاء (المدارس والمصانع والشركات)</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        بوابة إلكترونية تتيح لمدراء المنشآت تحميل شهادات الصيانة الدورية بصيغة PDF فورياً، متابعة تاريخ سريان رخصة الدفاع المدني، طلب صيانة طارئة بضغطة زر، واستعراض سجل الزيارات السابقة.
                    </p>
                    <div class="grid sm:grid-cols-2 gap-2 pt-2 border-t border-slate-100 text-xs text-slate-500">
                        <div>• تحميل عقود وشهادات الصيانة AMC</div>
                        <div>• تنبيهات اقتراب انتهاء التراخيص الحكومية</div>
                        <div>• طلب فني طوارئ على مدار 24 ساعة</div>
                        <div>• جدولة خطط وفرضيات الإخلاء</div>
                    </div>
                </div>

            </div>

            <!-- Login Demo Box -->
            <div class="bg-slate-900 text-white p-8 rounded-2xl text-center space-y-4 max-w-2xl mx-auto">
                <h3 class="text-xl font-bold">جاهز لتجربة النظام؟</h3>
                <p class="text-xs text-slate-300">
                    يمكنك الدخول إلى بوابة النظام وتجربة الحسابات الميدانية لمختلف الأدوار.
                </p>
                <div class="pt-2">
                    <a href="{{ route('login') }}" class="inline-block px-6 py-2.5 bg-white text-slate-900 hover:bg-slate-100 font-bold text-xs rounded-lg transition-colors">
                        دخول بوابة النظام الآن
                    </a>
                </div>
            </div>

        </div>
    </section>

@endsection
