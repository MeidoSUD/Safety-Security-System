@extends('layouts.dashboard')

@section('title', 'إعدادات المنظومة وبيع حلول الـ SaaS | نبيكو ERP')
@section('page_title', 'إعدادات SaaS المتعدد، تسعير النطاقات الجغرافية، وباقات الاشتراك')

@section('content')

    <!-- TOP PROMO BANNER: SAAS READY FOR SELLING -->
    <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-400 text-xs font-bold border border-emerald-500/30">
                    <span>✨ حل برمجي متكامل قابل لإعادة البيع (Multi-Tenant SaaS Solution)</span>
                </div>
                <h2 class="text-xl font-black">
                    تهيئة نظام الـ SaaS لشركات السلامة والأمن الصناعي
                </h2>
                <p class="text-xs text-slate-300 max-w-2xl leading-relaxed">
                    النظام مهيأ كمنظومة متعددة الشركات (Multi-Tenancy). يمكنك إضافة شركات سلامة جديدة، تخصيص تسعيرات المعاينة الجغرافية لكل مدينة، وتفعيل بوابات التنبيه التلقائي عبر الرسائل القصيرة.
                </p>
            </div>
            
            <div class="p-4 bg-white/10 rounded-2xl backdrop-blur-sm border border-white/15 text-center shrink-0 space-y-1">
                <span class="text-xs text-slate-300 block">إجمالي الشركات المسجلة:</span>
                <span class="text-2xl font-black font-mono text-emerald-400">{{ $companies->count() }} شركات</span>
            </div>
        </div>
    </div>

    <!-- MAIN TWO-COLUMN SETTINGS GRID -->
    <div class="grid lg:grid-cols-12 gap-8">
        
        <!-- LEFT 7 COLS: CURRENT TENANT CONFIGURATION (Zone Pricing, SMS, Info) -->
        <div class="lg:col-span-7 bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm space-y-6">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div class="flex items-center gap-2">
                    <span class="text-xl">⚙️</span>
                    <h3 class="text-sm font-bold text-slate-900">تخصيص بيانات وتسعيرات الشركة النشطة</h3>
                </div>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                    {{ $currentCompany->name }}
                </span>
            </div>

            <form action="{{ route('dashboard.saas_settings.update', $currentCompany->id) }}" method="POST" class="space-y-4 text-xs">
                @csrf

                <div>
                    <label class="block font-bold text-slate-700 mb-1">اسم شركة السلامة <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ $currentCompany->name }}" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">رقم السجل التجاري</label>
                        <input type="text" name="cr_number" value="{{ $currentCompany->cr_number }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-mono">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">الرقم الضريبي (VAT)</label>
                        <input type="text" name="tax_number" value="{{ $currentCompany->tax_number }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-mono">
                    </div>
                </div>

                <!-- ZONE PRICING CONFIGURATION (Core User Requirement) -->
                <div class="p-4 bg-blue-50/60 rounded-2xl border border-blue-200 space-y-3">
                    <div class="flex items-center gap-1.5 text-blue-950 font-bold text-xs">
                        <span>📍</span>
                        <span>إعداد تسعيرات زيارات المعاينة لغير المتعاقدين (Zone Pricing):</span>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">داخل نطاق المدينة (ر.س) <span class="text-red-500">*</span></label>
                            <input type="number" step="0.01" name="zone_rate_inside" value="{{ $currentCompany->zone_rate_inside }}" required class="w-full bg-white border border-slate-300 rounded-xl p-2.5 text-xs font-black font-mono text-slate-900">
                            <span class="text-[10px] text-slate-500 mt-1 block">نطاق الرياض، جدة، الدمام</span>
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 mb-1">خارج نطاق المدينة والمناطق البعيدة (ر.س) <span class="text-red-500">*</span></label>
                            <input type="number" step="0.01" name="zone_rate_outside" value="{{ $currentCompany->zone_rate_outside }}" required class="w-full bg-white border border-slate-300 rounded-xl p-2.5 text-xs font-black font-mono text-slate-900">
                            <span class="text-[10px] text-slate-500 mt-1 block">المحافظات والمدن الصناعية الخارجية</span>
                        </div>
                    </div>
                </div>

                <!-- SaaS Plan & Status -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">باقة اشتراك الـ SaaS <span class="text-red-500">*</span></label>
                        <select name="subscription_plan" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800">
                            <option value="enterprise" {{ $currentCompany->subscription_plan === 'enterprise' ? 'selected' : '' }}>باقة المؤسسات الشاملة (Enterprise)</option>
                            <option value="pro" {{ $currentCompany->subscription_plan === 'pro' ? 'selected' : '' }}>باقة المحترفين (Pro)</option>
                            <option value="starter" {{ $currentCompany->subscription_plan === 'starter' ? 'selected' : '' }}>باقة البداية (Starter)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">حالة الاشتراك <span class="text-red-500">*</span></label>
                        <select name="subscription_status" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800">
                            <option value="active" {{ $currentCompany->subscription_status === 'active' ? 'selected' : '' }}>نشط وساري (Active)</option>
                            <option value="trial" {{ $currentCompany->subscription_status === 'trial' ? 'selected' : '' }}>فترة تجريبية (Trial)</option>
                            <option value="expired" {{ $currentCompany->subscription_status === 'expired' ? 'selected' : '' }}>منتهي الصلاحية (Expired)</option>
                        </select>
                    </div>
                </div>

                <!-- Automated Reminder Toggle -->
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 flex items-center justify-between">
                    <div>
                        <b class="text-slate-800 block text-xs">تفعيل التذكير الآلي للزيارات بـ 48 ساعة</b>
                        <span class="text-[10px] text-slate-500">إرسال SMS تلقائي للعميل والفني قبل الموعد.</span>
                    </div>
                    <input type="checkbox" name="sms_reminder_enabled" value="1" {{ $currentCompany->sms_reminder_enabled ? 'checked' : '' }} class="w-5 h-5 rounded text-blue-600">
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-lg shadow-blue-500/20 transition-all">
                        حفظ التعديلات والتسعيرات ✓
                    </button>
                </div>
            </form>
        </div>

        <!-- RIGHT 5 COLS: MULTI-TENANT COMPANIES LIST (For SaaS Selling) -->
        <div class="lg:col-span-5 space-y-6">
            
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                        <span>🏢</span>
                        <span>شركات السلامة المشتركة (Tenants)</span>
                    </h3>
                    <span class="text-[10px] font-bold text-slate-400">SaaS Multi-Tenancy</span>
                </div>

                <div class="space-y-3">
                    @foreach($companies as $c)
                        <div class="p-4 rounded-2xl border {{ $c->id === $currentCompany->id ? 'border-blue-300 bg-blue-50/40 ring-2 ring-blue-100' : 'border-slate-200 bg-slate-50/50' }} space-y-2 text-xs">
                            <div class="flex items-center justify-between">
                                <b class="text-slate-900 font-bold text-xs">{{ $c->name }}</b>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                    {{ $c->subscription_plan }}
                                </span>
                            </div>

                            <div class="grid grid-cols-3 gap-2 pt-2 border-t border-slate-200 text-center text-[10px]">
                                <div class="bg-white p-1.5 rounded-lg border border-slate-200">
                                    <span class="text-slate-400 block">المستخدمين</span>
                                    <b class="font-mono text-slate-800 text-xs">{{ $c->users_count }}</b>
                                </div>
                                <div class="bg-white p-1.5 rounded-lg border border-slate-200">
                                    <span class="text-slate-400 block">المنشآت</span>
                                    <b class="font-mono text-slate-800 text-xs">{{ $c->facilities_count }}</b>
                                </div>
                                <div class="bg-white p-1.5 rounded-lg border border-slate-200">
                                    <span class="text-slate-400 block">العقود</span>
                                    <b class="font-mono text-slate-800 text-xs">{{ $c->contracts_count }}</b>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- SaaS Packages Overview Box -->
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-3xl p-6 text-white space-y-3 text-xs">
                <b class="text-sm font-bold text-white block">📦 باقات اشتراك SaaS لشركات السلامة:</b>
                <div class="space-y-2 text-[11px] text-slate-300">
                    <div class="p-2.5 rounded-xl bg-slate-800/80 border border-slate-700 flex justify-between items-center">
                        <div>
                            <b class="text-white">باقة المؤسسات (Enterprise)</b>
                            <div class="text-[10px] text-slate-400">عقود وزيارات غير محدودة + ربط منصة سلامة</div>
                        </div>
                        <span class="font-mono font-bold text-emerald-400">2,500 ر.س / شهر</span>
                    </div>

                    <div class="p-2.5 rounded-xl bg-slate-800/80 border border-slate-700 flex justify-between items-center">
                        <div>
                            <b class="text-white">باقة المحترفين (Pro)</b>
                            <div class="text-[10px] text-slate-400">حتى 150 منشأة + 10 مهندسين ميدان</div>
                        </div>
                        <span class="font-mono font-bold text-blue-400">1,400 ر.س / شهر</span>
                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection
