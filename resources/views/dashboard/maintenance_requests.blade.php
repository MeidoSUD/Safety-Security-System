@extends('layouts.dashboard')

@section('title', 'طلبات الصيانة والكشف الميداني | نبيكو ERP')
@section('page_title', 'إدارة طلبات الصيانة ومعاينة المواقع وبلاغات الطوارئ')

@section('content')

    <!-- TOP BAR & CONTROLS -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <div class="flex items-center gap-2">
            <span class="text-xl">📥</span>
            <div>
                <h2 class="text-sm font-bold text-slate-900">طلبات الصيانة الواردة من العملاء والإدارة</h2>
                <div class="text-[11px] text-slate-500">إجمالي الطلبات: {{ $requests->count() }} • المعلقة: {{ $requests->where('status', 'pending')->count() }}</div>
            </div>
        </div>

        <button onclick="document.getElementById('new-request-modal').showModal()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-lg shadow-blue-500/20 flex items-center gap-2">
            <span>➕</span>
            <span>تقديم طلب صيانة / كشف جديد</span>
        </button>
    </div>

    <!-- REQUESTS LIST -->
    <div class="space-y-4">
        @forelse($requests as $req)
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-4 hover:border-blue-300 transition-all">
                
                <div class="flex flex-wrap items-start justify-between gap-4 border-b border-slate-100 pb-4">
                    <div class="space-y-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="font-mono text-xs font-bold text-slate-700 bg-slate-100 px-2 py-0.5 rounded">#{{ $req->request_number }}</span>
                            <h3 class="text-sm sm:text-base font-bold text-slate-900">{{ $req->title }}</h3>
                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold {{ $req->priority_badge_color }}">
                                {{ $req->type_arabic }} ({{ $req->priority }})
                            </span>

                            @if($req->status === 'pending')
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-100 text-amber-900 border border-amber-300">
                                    معلق بانتظار الجدولة
                                </span>
                            @elseif($req->status === 'scheduled')
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-100 text-blue-900 border border-blue-300">
                                    تمت الجدولة إلى زيارة
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-900 border border-emerald-300">
                                    مكتمل ✓
                                </span>
                            @endif
                        </div>

                        <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500 pt-1">
                            <span>المنشأة: <b class="text-slate-800">{{ $req->facility->name }}</b></span>
                            <span>•</span>
                            <span>المدينة: <b>{{ $req->facility->city }}</b></span>
                            <span>•</span>
                            <span>نوع النظام: <b class="font-mono text-blue-700">{{ $req->system_type }}</b></span>
                            <span>•</span>
                            <span>تاريخ الرفع: <b class="font-mono">{{ $req->created_at->format('Y-m-d h:i A') }}</b></span>
                        </div>
                    </div>

                    <!-- Convert / Manage Action -->
                    <div class="shrink-0 flex items-center gap-2">
                        @if($req->status === 'pending')
                            <button onclick="openConvertModal({{ $req->id }}, '{{ $req->title }}', '{{ $req->facility->name }}')" class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow transition-colors flex items-center gap-1.5">
                                <span>👷</span>
                                <span>جدولة وتحويل إلى زيارة ميدانية</span>
                            </button>
                        @elseif($req->visit)
                            <a href="{{ route('dashboard.visits.manage', $req->visit->id) }}" class="px-3.5 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition-colors">
                                متابعة الزيارة #{{ $req->visit->visit_number }} 🔍
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Description & Attached Photos -->
                <div class="grid lg:grid-cols-12 gap-4 items-center">
                    <div class="lg:col-span-8 text-xs text-slate-600 bg-slate-50 p-4 rounded-xl border border-slate-200 space-y-1">
                        <b>وصف المشكلة والبلاغ:</b>
                        <p class="text-slate-700 leading-relaxed">{{ $req->description ?? 'لا يوجد وصف إضافي.' }}</p>
                    </div>

                    <div class="lg:col-span-4 bg-white p-4 rounded-xl border border-slate-200 text-xs space-y-2">
                        <b class="text-slate-800 block">الصور المرفقة من مقدم الطلب:</b>
                        @if($req->site_photos && count($req->site_photos) > 0)
                            <div class="flex items-center gap-2">
                                @foreach($req->site_photos as $photo)
                                    <img src="{{ $photo }}" alt="صورة الموقع" class="w-12 h-12 rounded-lg object-cover border border-slate-300">
                                @endforeach
                            </div>
                        @else
                            <span class="text-slate-400 text-[11px] block">لا توجد صور مرفقة مع الطلب</span>
                        @endif
                    </div>
                </div>

            </div>
        @empty
            <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center text-slate-500 space-y-2">
                <span class="text-4xl block">📥</span>
                <b class="text-sm text-slate-800">لا توجد طلبات صيانة حالياً</b>
            </div>
        @endforelse
    </div>

    <!-- MODAL 1: NEW MAINTENANCE REQUEST -->
    <dialog id="new-request-modal" class="rounded-3xl border border-slate-200 p-0 shadow-2xl w-full max-w-xl bg-white backdrop:bg-slate-900/60">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50 rounded-t-3xl">
            <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                <span>📥</span>
                <span>تقديم طلب صيانة / كشف جديد</span>
            </h3>
            <button onclick="document.getElementById('new-request-modal').close()" class="text-slate-400 hover:text-slate-700">✕</button>
        </div>

        <form action="{{ route('dashboard.maintenance_requests.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 text-xs">
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

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">نوع الطلب <span class="text-red-500">*</span></label>
                    <select name="type" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800">
                        <option value="emergency">زيارة طارئة لعطل حرج</option>
                        <option value="preventive">صيانة وقائية دورية</option>
                        <option value="inspection">فحص ومعاينة موقع</option>
                        <option value="quote_request">طلب عرض سعر وتجهيز كوتيشن</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">مستوى الأولوية <span class="text-red-500">*</span></label>
                    <select name="priority" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800">
                        <option value="critical">حرجة / طارئة (Critical)</option>
                        <option value="high">عالية (High)</option>
                        <option value="medium" selected>متوسطة (Medium)</option>
                        <option value="low">عادية (Low)</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">نظام السلامة المعني <span class="text-red-500">*</span></label>
                <select name="system_type" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800">
                    <option value="fire_pumps">مضخات الحريق وشبكة الضغط</option>
                    <option value="fire_alarm">لوحة وشبكة إنذار الحريق</option>
                    <option value="sprinklers">شبكة الرش الآلي والمحابس</option>
                    <option value="fire_extinguishers">طفايات الحريق وخراطيم الإطفاء</option>
                    <option value="fm200_co2">أنظمة الإخماد بالغاز (FM200 / CO2)</option>
                    <option value="all_systems">جميع أنظمة السلامة المتكاملة</option>
                </select>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">عنوان الطلب / ملخص البلاغ <span class="text-red-500">*</span></label>
                <input type="text" name="title" required placeholder="مثال: تسريب مياه في محبس مضخة الديزل الرئيسية" class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">تفاصيل البلاغ / وصف العطل</label>
                <textarea name="description" rows="3" placeholder="اكتب تفاصيل إضافية لتسهيل مهمة الفنيين..." class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs"></textarea>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">رفع صورة العطل / الموقع</label>
                <input type="file" name="site_photo_file" accept="image/*" class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2 text-xs">
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="document.getElementById('new-request-modal').close()" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl font-bold">إلغاء</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-xl font-bold">إرسال الطلب ✓</button>
            </div>
        </form>
    </dialog>

    <!-- MODAL 2: CONVERT REQUEST TO SCHEDULED VISIT -->
    <dialog id="convert-modal" class="rounded-3xl border border-slate-200 p-0 shadow-2xl w-full max-w-lg bg-white backdrop:bg-slate-900/60">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50 rounded-t-3xl">
            <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                <span>👷</span>
                <span>جدولة الطلب وتحويله إلى زيارة ميدانية</span>
            </h3>
            <button onclick="document.getElementById('convert-modal').close()" class="text-slate-400 hover:text-slate-700">✕</button>
        </div>

        <form id="convert-form" method="POST" class="p-6 space-y-4 text-xs">
            @csrf
            
            <div class="p-3 bg-blue-50 border border-blue-200 rounded-xl space-y-1 text-blue-950">
                <b id="convert-facility-name" class="block font-bold"></b>
                <span id="convert-req-title" class="text-[11px] text-blue-800"></span>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">إسناد المهندس الفاحص <span class="text-red-500">*</span></label>
                <select name="assigned_engineer_id" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800">
                    <option value="">-- اختر المهندس / الفني --</option>
                    @foreach($engineers as $eng)
                        <option value="{{ $eng->id }}">{{ $eng->name }} ({{ $eng->job_title ?? 'مهندس' }})</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">تاريخ الزيارة <span class="text-red-500">*</span></label>
                    <input type="date" name="scheduled_date" value="{{ date('Y-m-d') }}" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold font-mono">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">وقت الزيارة <span class="text-red-500">*</span></label>
                    <input type="time" name="scheduled_time" value="10:00" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold font-mono">
                </div>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="document.getElementById('convert-modal').close()" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl font-bold">إلغاء</button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-xl font-bold">تأكيد الجدولة والإسناد ✓</button>
            </div>
        </form>
    </dialog>

    <script>
        function openConvertModal(reqId, title, facilityName) {
            const form = document.getElementById('convert-form');
            form.action = `/dashboard/maintenance-requests/${reqId}/convert-to-visit`;
            document.getElementById('convert-facility-name').innerText = 'الموقع: ' + facilityName;
            document.getElementById('convert-req-title').innerText = 'البلاغ: ' + title;
            document.getElementById('convert-modal').showModal();
        }
    </script>

@endsection
