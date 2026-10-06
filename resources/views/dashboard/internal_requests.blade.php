@extends('layouts.dashboard')

@section('title', 'طلبات الصيانة بين إدارات الشركة | نبيكو العربية ERP')
@section('page_title', 'نظام طلبات الصيانة والمهام المتبادلة بين إدارات الشركة (Internal Requests)')

@section('content')

    <!-- Header Banner & Create Ticket Button -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                <span>🔄 منظومة الطلبات والتنسيق الداخلي بين الإدارات</span>
                <span class="text-xs px-2.5 py-0.5 rounded-full bg-purple-50 text-purple-700 font-semibold">Inter-Departmental System</span>
            </h2>
            <p class="text-xs text-slate-500 mt-0.5">
                تتيح التواصل المباشر وتمرير طلبات الصيانة وقطع الغيار والاعتمادات الهندسية بين أقسام الشركة وتتبع دورة العمل: جديد ← تم التوجيه ← قيد المعالجة ← مكتمل.
            </p>
        </div>

        <button onclick="openInternalModal()" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-lg text-xs font-bold transition-colors flex items-center gap-1.5 shrink-0">
            <span>+</span>
            <span>إنشاء طلب داخلي جديد</span>
        </button>
    </div>

    <!-- Department Quick Stats Strip -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6 text-xs">
        <div class="p-4 bg-white rounded-xl border border-slate-200 shadow-sm space-y-1">
            <span class="text-slate-500">طلبات جديدة (New)</span>
            <div class="text-2xl font-black text-purple-700 font-mono">1</div>
            <span class="text-[10px] text-purple-800">بانتظار التوجيه</span>
        </div>

        <div class="p-4 bg-white rounded-xl border border-slate-200 shadow-sm space-y-1">
            <span class="text-slate-500">تم التوجيه (Assigned)</span>
            <div class="text-2xl font-black text-blue-700 font-mono">1</div>
            <span class="text-[10px] text-blue-800">لدى المهندس المعتمد</span>
        </div>

        <div class="p-4 bg-white rounded-xl border border-slate-200 shadow-sm space-y-1">
            <span class="text-slate-500">قيد المعالجة (In Progress)</span>
            <div class="text-2xl font-black text-amber-700 font-mono">1</div>
            <span class="text-[10px] text-amber-800">جاري التجهيز بالمستودع</span>
        </div>

        <div class="p-4 bg-white rounded-xl border border-slate-200 shadow-sm space-y-1">
            <span class="text-slate-500">مكتمل ومغلق (Completed)</span>
            <div class="text-2xl font-black text-emerald-700 font-mono">1</div>
            <span class="text-[10px] text-emerald-800">تم الإنجاز بنجاح</span>
        </div>
    </div>

    <!-- Internal Requests Cards -->
    <div class="space-y-4">
        @foreach($internalRequests as $req)
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-4">
                
                <!-- Ticket Header -->
                <div class="flex flex-wrap items-start justify-between gap-3 border-b border-slate-100 pb-3">
                    <div class="space-y-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="font-mono text-xs font-bold text-slate-700 bg-slate-100 px-2 py-0.5 rounded">#{{ $req['id'] }}</span>
                            <h3 class="text-sm font-bold text-slate-900">{{ $req['title'] }}</h3>
                            
                            @if($req['priority_badge'] == 'red')
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-800 border border-red-200">
                                    🚨 أولوية {{ $req['priority'] }}
                                </span>
                            @else
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                    ⚠️ أولوية {{ $req['priority'] }}
                                </span>
                            @endif
                        </div>

                        <div class="text-xs text-slate-500 flex flex-wrap gap-4 mt-1">
                            <span>من قسم: <b class="text-slate-800">{{ $req['from_dept'] }}</b></span>
                            <span>←</span>
                            <span>إلى قسم: <b class="text-blue-700">{{ $req['to_dept'] }}</b></span>
                            <span>•</span>
                            <span>المنشأة المعنية: <b>{{ $req['facility_ref'] }}</b></span>
                            <span>•</span>
                            <span>التاريخ: <span class="font-mono">{{ $req['date'] }}</span></span>
                        </div>
                    </div>

                    <!-- Workflow Status Badge -->
                    <div>
                        @if($req['status'] == 'new')
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-900 border border-purple-300">
                                {{ $req['status_label'] }}
                            </span>
                        @elseif($req['status'] == 'assigned')
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-900 border border-blue-300">
                                {{ $req['status_label'] }}
                            </span>
                        @elseif($req['status'] == 'in_progress')
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-900 border border-amber-300 animate-pulse">
                                {{ $req['status_label'] }}
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-900 border border-emerald-300">
                                {{ $req['status_label'] }}
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Ticket Content -->
                <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 text-xs text-slate-700 leading-relaxed">
                    {{ $req['details'] }}
                </div>

                <!-- Workflow Step Actions -->
                <div class="flex flex-wrap items-center justify-between gap-3 pt-1 text-xs">
                    <div class="text-slate-500">
                        مقدم الطلب: <b>{{ $req['created_by'] }}</b>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <button onclick="alert('تم تحديث حالة الطلب إلى: قيد المعالجة (In Progress)')" class="px-3 py-1.5 bg-white hover:bg-slate-100 border border-slate-300 text-slate-800 rounded font-bold">
                            تحديث الحالة 🔄
                        </button>
                        <button onclick="alert('تم تحويل الطلب وإضافة ملاحظة للإدارة المعنية')" class="px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white rounded font-bold">
                            الرد وإغلاق الطلب ✓
                        </button>
                    </div>
                </div>

            </div>
        @endforeach
    </div>

    <!-- MODAL: CREATE NEW INTERNAL REQUEST -->
    <dialog id="internalModal" class="rounded-2xl p-0 bg-white border border-slate-200 shadow-2xl max-w-lg w-full text-slate-800 m-auto overflow-hidden">
        <div class="p-6 space-y-4">
            <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                <b class="text-base text-slate-900 flex items-center gap-1.5">
                    <span>🔄</span>
                    <span>إنشاء طلب صيانة / مهمة داخلية بين الإدارات</span>
                </b>
                <button onclick="closeInternalModal()" class="text-slate-400 hover:text-slate-900 p-1">✕</button>
            </div>

            <form onsubmit="handleInternalSubmit(event)" class="space-y-3 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">عنوان الطلب الرئيسي *</label>
                    <input type="text" required placeholder="مثال: طلب اعتماد تقرير فحص مضخات ديزل" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-900">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">من إدارة (المرسل) *</label>
                        <select class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-900">
                            <option>إدارة العمليات والمشاريع الميدانية</option>
                            <option>الإدارة الهندسية والاستشارات</option>
                            <option>إدارة المبيعات والعقود</option>
                            <option>إدارة المشتريات والمستودعات</option>
                            <option>الإدارة المالية والتحصيل</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">إلى إدارة (المستلم) *</label>
                        <select class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-900">
                            <option>الإدارة الهندسية والاستشارات</option>
                            <option>إدارة المشتريات والمستودعات</option>
                            <option>إدارة العمليات والمشاريع الميدانية</option>
                            <option>الإدارة المالية والتحصيل</option>
                            <option>إدارة المبيعات والعقود</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">المنشأة المعنية (اختياري)</label>
                        <input type="text" placeholder="مثال: مجمع مدارس الأندلس الأهلية" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-900">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">درجة الأولوية *</label>
                        <select class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-900">
                            <option>عاجلة / حرجة (Urgent)</option>
                            <option>عالية (High)</option>
                            <option>متوسطة (Medium)</option>
                            <option>عادية (Normal)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">تفاصيل ومبررات الطلب *</label>
                    <textarea rows="3" required placeholder="اكتب المطلوب بالتفصيل..." class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-900"></textarea>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3 bg-slate-900 hover:bg-slate-800 text-white rounded-lg font-bold text-xs">
                        إرسال الطلب للإدارة المعنية وتعيين كود التتبع ✓
                    </button>
                </div>
            </form>
        </div>
    </dialog>

    <script>
        function openInternalModal() {
            document.getElementById('internalModal').showModal();
        }

        function closeInternalModal() {
            document.getElementById('internalModal').close();
        }

        function handleInternalSubmit(e) {
            e.preventDefault();
            closeInternalModal();
            alert('تم إرسال الطلب الداخلي بنجاح وتم إشعار مدير القسم المختص.');
        }
    </script>

@endsection
