@extends('layouts.dashboard')

@section('title', 'المنشآت والمواقع الميدانية | نبيكو ERP')
@section('page_title', 'إدارة مواقع العملاء، النطاقات الجغرافية، وتراخيص السلامة')

@section('content')

    <!-- TOP CONTROLS & ADD FACILITY BUTTON -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <div class="flex items-center gap-2">
            <span class="text-xl">🏢</span>
            <div>
                <h2 class="text-sm font-bold text-slate-900">المواقع والمنشآت المشمولة بالخدمة</h2>
                <div class="text-[11px] text-slate-500">إجمالي المنشآت: {{ $facilities->count() }} منشأة</div>
            </div>
        </div>

        <button onclick="document.getElementById('new-facility-modal').showModal()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-lg shadow-blue-500/20 flex items-center gap-2">
            <span>➕</span>
            <span>تسجيل منشأة / موقع جديد</span>
        </button>
    </div>

    <!-- FACILITIES GRID -->
    <div class="grid md:grid-cols-2 gap-6">
        @forelse($facilities as $fac)
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-4 hover:border-blue-300 transition-all">
                
                <div class="flex items-start justify-between gap-3 border-b border-slate-100 pb-3">
                    <div class="space-y-1">
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-700">
                            {{ $fac->sector_arabic }}
                        </span>
                        <h3 class="text-base font-bold text-slate-900">{{ $fac->name }}</h3>
                        <div class="text-xs text-slate-500">{{ $fac->city }} • {{ $fac->district ?? '' }}</div>
                    </div>

                    <div class="text-left space-y-1">
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $fac->zone_type === 'inside_city' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-purple-50 text-purple-700 border border-purple-200' }}">
                            {{ $fac->zone_label }}
                        </span>
                        @if($fac->activeContract)
                            <div class="text-[10px] text-emerald-600 font-bold">🟢 عقد ساري</div>
                        @else
                            <div class="text-[10px] text-slate-400 font-bold">⚪ غير متعاقد</div>
                        @endif
                    </div>
                </div>

                <div class="space-y-2 text-xs text-slate-600 bg-slate-50 p-3 rounded-xl border border-slate-200">
                    <div><b>مسؤول الموقع:</b> {{ $fac->contact_person ?? 'غير مسجل' }} • <span class="font-mono">{{ $fac->contact_phone ?? '-' }}</span></div>
                    <div><b>رخصة الدفاع المدني:</b> <span class="font-mono font-bold text-slate-800">{{ $fac->safety_license_number ?? 'غير متوفرة / جديدة' }}</span></div>
                    @if($fac->notes)
                        <div class="text-slate-500 pt-1 text-[11px]">{{ $fac->notes }}</div>
                    @endif
                </div>

                <div class="flex items-center justify-between pt-1 text-xs">
                    <span class="text-slate-500">إجمالي الزيارات: <b class="font-mono text-slate-800">{{ $fac->visits->count() }}</b></span>
                    <a href="{{ route('dashboard.visits') }}" class="text-blue-600 font-bold hover:underline">
                        عرض الزيارات المرتبطة ←
                    </a>
                </div>

            </div>
        @empty
            <div class="md:col-span-2 text-center py-12 bg-white rounded-2xl border border-slate-200 text-slate-400">
                لا توجد منشآت مسجلة حالياً.
            </div>
        @endforelse
    </div>

    <!-- MODAL: ADD FACILITY -->
    <dialog id="new-facility-modal" class="rounded-3xl border border-slate-200 p-0 shadow-2xl w-full max-w-xl bg-white backdrop:bg-slate-900/60">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50 rounded-t-3xl">
            <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                <span>🏢</span>
                <span>تسجيل منشأة / موقع جديد</span>
            </h3>
            <button onclick="document.getElementById('new-facility-modal').close()" class="text-slate-400 hover:text-slate-700">✕</button>
        </div>

        <form action="{{ route('dashboard.facilities.store') }}" method="POST" class="p-6 space-y-4 text-xs">
            @csrf

            <div>
                <label class="block font-bold text-slate-700 mb-1">اسم المنشأة / المجمع <span class="text-red-500">*</span></label>
                <input type="text" name="name" required placeholder="مثال: مستودعات الرياض اللوجستية" class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">قطاع المنشأة <span class="text-red-500">*</span></label>
                    <select name="sector" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800">
                        <option value="commercial">قطاع تجاري ومولات</option>
                        <option value="industrial">قطاع صناعي ومصانع</option>
                        <option value="educational">قطاع تعليمي ومدارس</option>
                        <option value="medical">قطاع طبي ومستشفيات</option>
                        <option value="warehousing">مستودعات وتخزين</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">النطاق الجغرافي <span class="text-red-500">*</span></label>
                    <select name="zone_type" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800">
                        <option value="inside_city">داخل نطاق المدينة (350 ر.س)</option>
                        <option value="outside_city">خارج نطاق المدينة (650 ر.س)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">المدينة <span class="text-red-500">*</span></label>
                    <input type="text" name="city" value="الرياض" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">الحي / المنطقة الصناعية</label>
                    <input type="text" name="district" placeholder="مثال: حي الصحافة" class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">اسم مسؤول الموقع</label>
                    <input type="text" name="contact_person" placeholder="الاسم" class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">رقم الجوال</label>
                    <input type="text" name="contact_phone" placeholder="0500000000" class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold font-mono">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">رقم رخصة السلامة للدفاع المدني</label>
                    <input type="text" name="safety_license_number" placeholder="SCD-XXXX-XX" class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-mono">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">تاريخ انتهاء الرخصة</label>
                    <input type="date" name="safety_license_expiry" class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-mono">
                </div>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="document.getElementById('new-facility-modal').close()" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl font-bold">إلغاء</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-xl font-bold">حفظ المنشأة ✓</button>
            </div>
        </form>
    </dialog>

@endsection
