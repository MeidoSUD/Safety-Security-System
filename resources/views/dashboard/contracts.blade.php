@extends('layouts.dashboard')

@section('title', 'إدارة العقود والمرفقات | نبيكو ERP')
@section('page_title', 'إدارة العقود السارية، المرفقات الرسمية، وحصص الزيارات')

@section('content')

    <!-- TOP CONTROLS & ADD CONTRACT MODAL TRIGGER -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <div class="flex items-center gap-2">
            <span class="text-xl">🌲</span>
            <div>
                <h2 class="text-sm font-bold text-slate-900">منظومة العقود السنوية المعتمدة (AMC Management)</h2>
                <div class="text-[11px] text-slate-500">إجمالي العقود: {{ $contracts->count() }} • السارية: {{ $contracts->where('status', 'active')->count() }}</div>
            </div>
        </div>

        <button onclick="document.getElementById('new-contract-modal').showModal()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-lg shadow-blue-500/20 flex items-center gap-2">
            <span>➕</span>
            <span>إنشاء عقد صيانة سنوي جديد</span>
        </button>
    </div>

    <!-- CONTRACTS LIST -->
    <div class="space-y-4">
        @forelse($contracts as $c)
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-4 hover:border-blue-300 transition-all">
                
                <div class="flex flex-wrap items-start justify-between gap-4 border-b border-slate-100 pb-4">
                    <div class="space-y-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="font-mono text-xs font-bold text-slate-700 bg-slate-100 px-2 py-0.5 rounded">#{{ $c->contract_number }}</span>
                            <h3 class="text-base font-bold text-slate-900">{{ $c->title }}</h3>
                            
                            @if($c->status === 'active')
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                    🟢 ساري ونشط
                                </span>
                            @elseif($c->status === 'expired')
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-red-100 text-red-800 border border-red-300">
                                    🔴 منتهي الصلاحية
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800 border border-amber-300">
                                    🟡 ينتهي قريباً
                                </span>
                            @endif
                        </div>

                        <div class="text-xs text-slate-500 flex flex-wrap items-center gap-3 pt-1">
                            <span>المنشأة: <b class="text-slate-800">{{ $c->facility->name }}</b></span>
                            <span>•</span>
                            <span>المدينة: <b>{{ $c->facility->city }}</b></span>
                            <span>•</span>
                            <span>المدة: <span class="font-mono font-bold text-slate-700">{{ $c->start_date->format('Y-m-d') }} إلى {{ $c->end_date->format('Y-m-d') }}</span></span>
                        </div>
                    </div>

                    <div class="text-left space-y-1">
                        <div class="text-base font-black font-mono text-slate-900">{{ number_format($c->total_amount, 2) }} ر.س</div>
                        <span class="text-[10px] text-slate-400 font-bold block">القيمة الإجمالية للعقد</span>
                    </div>
                </div>

                <!-- Visits Quota vs Used & Attachment Slot -->
                <div class="grid sm:grid-cols-3 gap-4 text-xs bg-slate-50 p-4 rounded-xl border border-slate-200">
                    <div class="space-y-1">
                        <span class="text-slate-500 font-bold">حصة الزيارات الوقائية المعتمدة:</span>
                        <div class="flex items-center gap-2">
                            <span class="font-mono text-base font-black text-blue-600">{{ $c->visits_used }}</span>
                            <span class="text-slate-400 font-bold">/</span>
                            <span class="font-mono text-base font-black text-slate-700">{{ $c->visits_quota }} زيارات</span>
                        </div>
                    </div>

                    <div class="space-y-1 sm:border-r sm:border-slate-200 sm:pr-4">
                        <span class="text-slate-500 font-bold">الزيارات الميدانية المنفذة:</span>
                        <div class="text-slate-800 font-semibold">{{ $c->visits->count() }} زيارة مسجلة بالنظام</div>
                    </div>

                    <div class="space-y-1 sm:border-r sm:border-slate-200 sm:pr-4 flex items-center justify-between">
                        <div>
                            <span class="text-slate-500 font-bold block">ملف العقد الرسمي:</span>
                            <span class="text-[11px] text-slate-600">نسخة معتمدة وموقعة (PDF)</span>
                        </div>
                        <button onclick="alert('جاري تحميل نسخة العقد الرسمي المعتمدة')" class="px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white rounded-lg font-bold text-xs">
                            تحميل 📄
                        </button>
                    </div>
                </div>

            </div>
        @empty
            <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center text-slate-400">
                لا توجد عقود مسجلة حالياً.
            </div>
        @endforelse
    </div>

    <!-- MODAL: ADD NEW CONTRACT -->
    <dialog id="new-contract-modal" class="rounded-3xl border border-slate-200 p-0 shadow-2xl w-full max-w-xl bg-white backdrop:bg-slate-900/60">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50 rounded-t-3xl">
            <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                <span>🌲</span>
                <span>إنشاء عقد صيانة سنوي جديد</span>
            </h3>
            <button onclick="document.getElementById('new-contract-modal').close()" class="text-slate-400 hover:text-slate-700">✕</button>
        </div>

        <form action="{{ route('dashboard.contracts.store') }}" method="POST" class="p-6 space-y-4 text-xs">
            @csrf

            <div>
                <label class="block font-bold text-slate-700 mb-1">المنشأة المستهدفة <span class="text-red-500">*</span></label>
                <select name="facility_id" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800">
                    <option value="">-- حدد المنشأة --</option>
                    @foreach($facilities as $fac)
                        <option value="{{ $fac->id }}">{{ $fac->name }} ({{ $fac->city }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">مسمى العقد <span class="text-red-500">*</span></label>
                <input type="text" name="title" required placeholder="مثال: عقد الصيانة الوقائية الشاملة لشبكات الإطفاء والإنذار" class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">نوع العقد <span class="text-red-500">*</span></label>
                    <select name="contract_type" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800">
                        <option value="annual_comprehensive">عقد صيانة سنوي شامل</option>
                        <option value="preventive_maintenance">صيانة وقائية دورية</option>
                        <option value="periodic_inspection">فحص دوري ربع سنوي</option>
                        <option value="safety_compliance">مطابقة كود السلامة والدفاع المدني</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">القيمة الإجمالية (ر.س) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="total_amount" required placeholder="مثال: 35000" class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold font-mono">
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">تاريخ البدء <span class="text-red-500">*</span></label>
                    <input type="date" name="start_date" value="{{ date('Y-m-d') }}" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold font-mono">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">تاريخ الانتهاء <span class="text-red-500">*</span></label>
                    <input type="date" name="end_date" value="{{ date('Y-m-d', strtotime('+1 year')) }}" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold font-mono">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">عدد الزيارات المعتمدة <span class="text-red-500">*</span></label>
                    <input type="number" name="visits_quota" min="1" value="4" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold font-mono">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">ملاحظات وشروط خاصة</label>
                <textarea name="notes" rows="2" placeholder="شروط أو متطلبات خاصة بالعقد..." class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs"></textarea>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="document.getElementById('new-contract-modal').close()" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl font-bold">إلغاء</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-xl font-bold">حفظ واعتماد العقد ✓</button>
            </div>
        </form>
    </dialog>

@endsection
