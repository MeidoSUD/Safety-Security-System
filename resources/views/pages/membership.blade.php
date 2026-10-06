@extends('layouts.app')

@section('title', 'طلب عضوية وفتح ملف منشأة | درع السلامة')

@section('content')

    <!-- Header Banner -->
    <section class="bg-white border-b border-slate-200 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">طلب عضوية وفتح ملف منشأة</h1>
            <p class="text-sm text-slate-600 mt-2 max-w-2xl">
                سجل بيانات مدرستك أو مصنعك لفتح ملف هندسي، الحصول على عرض سعر لعقد الصيانة السنوي (AMC)، وتجديد رخصة الدفاع المدني.
            </p>
        </div>
    </section>

    <!-- Form Section -->
    <section class="py-12 bg-slate-50">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-10 shadow-sm">
                
                <form id="membership-form" onsubmit="handleFormSubmit(event)" class="space-y-6">
                    
                    <!-- Section 1: Facility Info -->
                    <div>
                        <h2 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-2 mb-4">
                            1. معلومات المنشأة
                        </h2>

                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">اسم المنشأة / المدرسة / المصنع *</label>
                                <input type="text" required placeholder="مثال: مدارس الرياض الأهلية" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3.5 py-2.5 text-xs text-slate-900 focus:outline-none focus:border-slate-900 focus:bg-white">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">نوع القطاع *</label>
                                <select class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3.5 py-2.5 text-xs text-slate-900 focus:outline-none focus:border-slate-900 focus:bg-white">
                                    <option value="school">مدرسة / مجمع تعليمي</option>
                                    <option value="factory">مصنع / منشأة صناعية</option>
                                    <option value="warehouse">مستودع لوجستي</option>
                                    <option value="commercial">مبنى تجاري / مجمع تسوق</option>
                                    <option value="medical">مستشفى / مجمع عيادات</option>
                                    <option value="contractor">شركة مقاولات</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">المدينة / المنطقة *</label>
                                <select class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3.5 py-2.5 text-xs text-slate-900 focus:outline-none focus:border-slate-900 focus:bg-white">
                                    <option value="riyadh">الرياض</option>
                                    <option value="jeddah">جدة</option>
                                    <option value="dammam">الدمام والخبر</option>
                                    <option value="makkah">مكة المكرمة</option>
                                    <option value="madinah">المدينة المنورة</option>
                                    <option value="jubail">الجبيل الصناعية</option>
                                    <option value="qassim">القصيم</option>
                                    <option value="other">منطقة أخرى</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">رقم السجل التجاري (إن وجد)</label>
                                <input type="text" placeholder="1010XXXXXX" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3.5 py-2.5 text-xs text-slate-900 focus:outline-none focus:border-slate-900 focus:bg-white">
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Contact Person -->
                    <div>
                        <h2 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-2 mb-4">
                            2. بيانات مسؤول التواصل
                        </h2>

                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">اسم المفوض / مسؤول السلامة *</label>
                                <input type="text" required placeholder="الاسم ثلاثي" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3.5 py-2.5 text-xs text-slate-900 focus:outline-none focus:border-slate-900 focus:bg-white">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">رقم الجوال للتواصل *</label>
                                <input type="tel" required placeholder="05XXXXXXXX" dir="ltr" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3.5 py-2.5 text-xs text-slate-900 focus:outline-none focus:border-slate-900 focus:bg-white text-right">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">البريد الإلكتروني للرخص والإشعارات *</label>
                                <input type="email" required placeholder="safety@example.com" dir="ltr" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3.5 py-2.5 text-xs text-slate-900 focus:outline-none focus:border-slate-900 focus:bg-white text-right">
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Services Required -->
                    <div>
                        <h2 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-2 mb-4">
                            3. الخدمات والأنظمة المطلوبة
                        </h2>

                        <div class="grid sm:grid-cols-2 gap-3 text-xs">
                            <label class="flex items-center gap-2 p-3 bg-slate-50 border border-slate-200 rounded-lg cursor-pointer hover:bg-slate-100">
                                <input type="checkbox" checked class="rounded text-slate-900">
                                <span>عقد صيانة سنوي دوري (AMC) معتمد</span>
                            </label>
                            <label class="flex items-center gap-2 p-3 bg-slate-50 border border-slate-200 rounded-lg cursor-pointer hover:bg-slate-100">
                                <input type="checkbox" checked class="rounded text-slate-900">
                                <span>إصدار / تجديد رخصة منصة سلامة</span>
                            </label>
                            <label class="flex items-center gap-2 p-3 bg-slate-50 border border-slate-200 rounded-lg cursor-pointer hover:bg-slate-100">
                                <input type="checkbox" class="rounded text-slate-900">
                                <span>تركيب شبكات إطفاء وإنذار جديدة</span>
                            </label>
                            <label class="flex items-center gap-2 p-3 bg-slate-50 border border-slate-200 rounded-lg cursor-pointer hover:bg-slate-100">
                                <input type="checkbox" class="rounded text-slate-900">
                                <span>اعتماد مخططات هندسية وCAD</span>
                            </label>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">ملاحظات أو مواصفات خاصة (المساحة، عدد المباني)</label>
                        <textarea rows="3" placeholder="اكتب أي معلومات إضافية عن موقع المنشأة أو موعد التفتيش المرغوب..." class="w-full bg-slate-50 border border-slate-300 rounded-lg p-3 text-xs text-slate-900 focus:outline-none focus:border-slate-900 focus:bg-white"></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" class="w-full py-3.5 rounded-lg font-bold text-white bg-slate-900 hover:bg-slate-800 transition-colors text-sm shadow-sm">
                            إرسال الطلب وفتح ملف المنشأة
                        </button>
                    </div>

                </form>

                <!-- Success State (Hidden by default) -->
                <div id="form-success" class="hidden text-center py-10 space-y-4">
                    <div class="w-14 h-14 bg-emerald-100 text-emerald-700 rounded-full flex items-center justify-center mx-auto text-2xl font-bold">
                        ✓
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">تم استلام طلبكم بنجاح!</h3>
                    <p class="text-xs text-slate-600 max-w-md mx-auto leading-relaxed">
                        تم فتح ملف رقمي لمنشأتكم برقم مرجعي: <b class="font-mono text-slate-900">#KSA-SAFE-8821</b>. سيقوم مهندس السلامة المعتمد بالتواصل معكم خلال ساعتين لترتيب الزيارة الميدانية.
                    </p>
                    <div class="pt-4">
                        <a href="{{ route('home') }}" class="inline-block px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs rounded-lg transition-colors">
                            العودة للرئيسية
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <script>
        function handleFormSubmit(e) {
            e.preventDefault();
            document.getElementById('membership-form').classList.add('hidden');
            document.getElementById('form-success').classList.remove('hidden');
        }
    </script>

@endsection
