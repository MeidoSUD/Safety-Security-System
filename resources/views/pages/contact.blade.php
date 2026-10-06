@extends('layouts.app')

@section('title', 'اتصل بنا | درع السلامة')

@section('content')

    <!-- Header Banner -->
    <section class="bg-white border-b border-slate-200 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">اتصل بنا وخدمة العملاء</h1>
            <p class="text-sm text-slate-600 mt-2 max-w-2xl">
                يسعدنا الرد على استفساراتكم وترتيب زيارات المعاينة الميدانية لمواقعكم في مختلف مناطق المملكة.
            </p>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-12 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-12 gap-8">
                
                <!-- Left Details (Right in RTL) -->
                <div class="md:col-span-5 space-y-6">
                    
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3">
                        <h2 class="text-base font-bold text-slate-900">مركز الاتصال الموحد</h2>
                        <div class="text-2xl font-black text-slate-900 font-mono">9200-SAFE-KSA</div>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            متاح طوال أيام الأسبوع لخدمات الطوارئ، طلبات عروض الأسعار، وتجديد رخص سلامة.
                        </p>
                        <div class="pt-2 text-xs text-slate-700 space-y-1 border-t border-slate-100">
                            <div>البريد الإلكتروني: <span class="font-mono font-semibold">info@safetyerp.sa</span></div>
                            <div>واتساب الدعم السريع: <span class="font-mono font-semibold">+966 50 000 0000</span></div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                        <h2 class="text-base font-bold text-slate-900">فروعنا بالمملكة 🇸🇦</h2>
                        
                        <div class="space-y-3 text-xs text-slate-600">
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <b class="text-slate-900 block mb-1">الرياض (المقر الرئيسي)</b>
                                <span>طريق الملك فهد - حي العليا - برج الأعمال</span>
                            </div>

                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <b class="text-slate-900 block mb-1">فرع جدة والمنطقة الغربية</b>
                                <span>طريق المدينة المنورة - حي الروضة</span>
                            </div>

                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <b class="text-slate-900 block mb-1">فرع الدمام والمنطقة الشرقية</b>
                                <span>طريق الملك فيصل - المدينة الصناعية الأولى</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Form (Left in RTL) -->
                <div class="md:col-span-7">
                    <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
                        <h2 class="text-lg font-bold text-slate-900">أرسل استفساراً أو طلب معاينة</h2>
                        
                        <form onsubmit="handleInquiry(event)" class="space-y-4">
                            <div class="grid sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">الاسم الكامل *</label>
                                    <input type="text" required placeholder="أدخل اسمك" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3.5 py-2.5 text-xs text-slate-900 focus:outline-none focus:border-slate-900 focus:bg-white">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">رقم الجوال *</label>
                                    <input type="tel" required placeholder="05XXXXXXXX" dir="ltr" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3.5 py-2.5 text-xs text-slate-900 focus:outline-none focus:border-slate-900 focus:bg-white text-right">
                                </div>
                            </div>

                            <div class="grid sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">اسم المنشأة / المدرسة / المصنع</label>
                                    <input type="text" placeholder="اسم المنشأة" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3.5 py-2.5 text-xs text-slate-900 focus:outline-none focus:border-slate-900 focus:bg-white">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">المدينة *</label>
                                    <select class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3.5 py-2.5 text-xs text-slate-900 focus:outline-none focus:border-slate-900 focus:bg-white">
                                        <option value="riyadh">الرياض</option>
                                        <option value="jeddah">جدة</option>
                                        <option value="dammam">الدمام والخبر</option>
                                        <option value="other">مدينة أخرى</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">نص الرسالة أو تفاصيل الطلب *</label>
                                <textarea rows="4" required placeholder="اكتب استفسارك هنا..." class="w-full bg-slate-50 border border-slate-300 rounded-lg p-3 text-xs text-slate-900 focus:outline-none focus:border-slate-900 focus:bg-white"></textarea>
                            </div>

                            <div>
                                <button type="submit" class="px-6 py-3 rounded-lg font-bold text-white bg-slate-900 hover:bg-slate-800 transition-colors text-xs shadow-sm">
                                    إرسال الرسالة
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <script>
        function handleInquiry(e) {
            e.preventDefault();
            alert('شكراً لتواصلك معنا، تم استلام رسالتك وسيتواصل معك ممثل خدمة العملاء قريباً.');
        }
    </script>

@endsection
