@extends('layouts.dashboard')

@section('title', 'إدارة العقود والمرفقات | نبيكو العربية ERP')
@section('page_title', 'إدارة العقود السارية، المرفقات الرسمية، وحساسية المشاريع')

@section('content')

    <!-- Top Summary Card -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4 mb-4">
            <div>
                <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <span>🌲 منظومة العقود المعتمدة (AMC Contracts Management)</span>
                    <span class="text-xs px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 font-semibold">148 منشأة متعاقدة</span>
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">
                    متابعة القيمة المالية بالريال السعودي، مؤشرات حساسية وخطورة المشروع، والمرفقات الرسمية الأربعة لكل عقد.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <button onclick="expandAll()" class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors">
                    توسيع الكل ⤢
                </button>
                <button onclick="collapseAll()" class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors">
                    طي الكل ⤡
                </button>
            </div>
        </div>

        <!-- Filter Status & Sensitivity Buttons -->
        <div class="flex flex-wrap items-center gap-2 text-xs">
            <span class="text-slate-500 font-bold">تصفية حسب الحالة:</span>
            <button onclick="filterContracts('all')" class="c-filter-btn active px-3 py-1.5 rounded-lg bg-slate-900 text-white font-bold">الكل (4)</button>
            <button onclick="filterContracts('active')" class="c-filter-btn px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 font-bold hover:bg-slate-200">🟢 ساري ونشط (2)</button>
            <button onclick="filterContracts('expiring')" class="c-filter-btn px-3 py-1.5 rounded-lg bg-amber-100 text-amber-900 font-bold hover:bg-amber-200">🟡 قارب على الانتهاء (1)</button>
            <button onclick="filterContracts('expired')" class="c-filter-btn px-3 py-1.5 rounded-lg bg-red-100 text-red-900 font-bold hover:bg-red-200">🔴 منتهي (1)</button>
        </div>
    </div>

    <!-- CONTRACT CARDS LIST -->
    <div class="space-y-5" id="contracts-tree-container">
        
        @foreach($contracts as $index => $c)
            <div class="border border-slate-200 rounded-2xl p-6 bg-white shadow-sm space-y-5 contract-card" data-status="{{ $c['status'] }}">
                
                <!-- Root Header: Contract & Key Badges -->
                <div class="flex flex-wrap items-start justify-between gap-4 cursor-pointer select-none border-b border-slate-100 pb-4" onclick="toggleNode('tree-body-{{ $index }}')">
                    
                    <div class="flex items-start gap-3.5">
                        <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center text-2xl shrink-0">
                            @if($c['type_badge'] == 'blue') 🎓 @elseif($c['type_badge'] == 'orange') 🏭 @elseif($c['type_badge'] == 'emerald') 📦 @else 🏥 @endif
                        </div>
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <h3 class="text-base font-bold text-slate-900">{{ $c['facility'] }}</h3>
                                
                                <!-- Status Badge with exact days remaining -->
                                @if($c['status'] == 'active')
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                        🟢 ساري (متبقي {{ $c['days_remaining'] }} يومًا)
                                    </span>
                                @elseif($c['status'] == 'expiring')
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-100 text-amber-900 border border-amber-300">
                                        🟡 قارب على الانتهاء (متبقي {{ $c['days_remaining'] }} يومًا)
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-red-100 text-red-900 border border-red-300">
                                        🔴 منتهي الصلاحية (منتهي منذ {{ abs($c['days_remaining']) }} يومًا)
                                    </span>
                                @endif

                                <!-- Project Sensitivity Badge (Requirement) -->
                                @if($c['sensitivity'] == 'high')
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-red-50 text-red-700 border border-red-200 flex items-center gap-1">
                                        <span>🚨 حساسية المشروع:</span>
                                        <span>{{ $c['sensitivity_label'] }}</span>
                                    </span>
                                @elseif($c['sensitivity'] == 'medium')
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-50 text-amber-800 border border-amber-200 flex items-center gap-1">
                                        <span>⚠️ حساسية المشروع:</span>
                                        <span>{{ $c['sensitivity_label'] }}</span>
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700 border border-slate-200 flex items-center gap-1">
                                        <span>🛡️ حساسية المشروع: منخفضة</span>
                                    </span>
                                @endif
                            </div>

                            <div class="text-xs text-slate-500 flex flex-wrap items-center gap-3 mt-2">
                                <span>رقم العقد: <b class="font-mono text-slate-800">#{{ $c['id'] }}</b></span>
                                <span>•</span>
                                <span>المدينة: <b>{{ $c['city'] }}</b></span>
                                <span>•</span>
                                <!-- Monetary Value (Requirement) -->
                                <span>إجمالي قيمة المشروع: <b class="font-mono text-base text-slate-900 font-extrabold bg-slate-50 px-2 py-0.5 rounded border border-slate-200">{{ $c['value'] }}</b></span>
                                <span>•</span>
                                <span>رخصة الدفاع المدني: <b class="{{ $c['salamah_status'] == 'سارية' ? 'text-emerald-700' : 'text-red-700' }} font-bold">{{ $c['salamah_status'] }}</b></span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        @if($c['status'] == 'expiring' || $c['status'] == 'expired')
                            <button onclick="event.stopPropagation(); alert('تم تجهيز مسودة تجديد العقد #{{ $c['id'] }} وإرسال إشعار لمنصة سلامة والعميل.')" class="px-3.5 py-1.5 bg-amber-600 hover:bg-amber-700 text-white rounded-lg font-bold text-xs shadow-sm">
                                🔄 تجديد العقد
                            </button>
                        @endif
                        <span id="icon-tree-body-{{ $index }}" class="text-slate-400 font-bold text-base">▼</span>
                    </div>

                </div>

                <!-- Expanded Body -->
                <div id="tree-body-{{ $index }}" class="space-y-4 pt-1">
                    
                    <!-- 1. DEDICATED ATTACHMENTS SECTION (Core Requirement) -->
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 space-y-3">
                        <div class="flex items-center justify-between text-xs font-bold text-slate-900">
                            <span class="flex items-center gap-1.5 text-blue-900">
                                <span>📎 المرفقات والمستندات الرسمية المعتمدة للعقد (4 مرفقات):</span>
                            </span>
                            <button onclick="alert('تم فتح نافذة إرفاق مستند جديد للعقد #{{ $c['id'] }}')" class="text-blue-700 hover:underline text-[11px] font-bold">
                                + إضافة أو تحديث مرفق
                            </button>
                        </div>

                        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-3 text-xs">
                            
                            <!-- Slot 1: Contract Copy (نسخة من العقد) -->
                            <div class="p-3 bg-white rounded-lg border border-slate-200 space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-bold text-blue-700 bg-blue-50 px-1.5 py-0.5 rounded">1. نسخة من العقد</span>
                                    <span class="text-[10px] text-slate-400 font-mono">{{ $c['attachments']['contract_copy']['size'] }}</span>
                                </div>
                                <div class="font-semibold text-slate-800 text-[11px] truncate" title="{{ $c['attachments']['contract_copy']['name'] }}">
                                    📄 {{ $c['attachments']['contract_copy']['name'] }}
                                </div>
                                <div class="text-[10px] text-slate-400">تاريخ الرفع: {{ $c['attachments']['contract_copy']['uploaded_at'] }}</div>
                                <button onclick="alert('تم فتح وتحميل: {{ $c['attachments']['contract_copy']['name'] }}')" class="w-full py-1 bg-slate-100 hover:bg-slate-200 text-slate-800 rounded font-bold text-[11px] text-center transition-colors">
                                    معاينة وتحميل PDF ⬇
                                </button>
                            </div>

                            <!-- Slot 2: Quotation (نسخة من الكوتيشن / العرض المالي) -->
                            <div class="p-3 bg-white rounded-lg border border-slate-200 space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-bold text-purple-700 bg-purple-50 px-1.5 py-0.5 rounded">2. الكوتيشن / العرض المالي</span>
                                    <span class="text-[10px] text-slate-400 font-mono">{{ $c['attachments']['quotation']['size'] }}</span>
                                </div>
                                <div class="font-semibold text-slate-800 text-[11px] truncate" title="{{ $c['attachments']['quotation']['name'] }}">
                                    💰 {{ $c['attachments']['quotation']['name'] }}
                                </div>
                                <div class="text-[10px] text-slate-400">تاريخ الرفع: {{ $c['attachments']['quotation']['uploaded_at'] }}</div>
                                <button onclick="alert('تم فتح وتحميل: {{ $c['attachments']['quotation']['name'] }}')" class="w-full py-1 bg-slate-100 hover:bg-slate-200 text-slate-800 rounded font-bold text-[11px] text-center transition-colors">
                                    معاينة وتحميل PDF ⬇
                                </button>
                            </div>

                            <!-- Slot 3: Bank Transfer / Payment Proof (نسخة من الحوالة البنكية) -->
                            <div class="p-3 bg-white rounded-lg border border-slate-200 space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded">3. الحوالة / إيصال السداد</span>
                                    <span class="text-[10px] text-slate-400 font-mono">{{ $c['attachments']['payment_proof']['size'] }}</span>
                                </div>
                                <div class="font-semibold text-slate-800 text-[11px] truncate" title="{{ $c['attachments']['payment_proof']['name'] }}">
                                    💳 {{ $c['attachments']['payment_proof']['name'] }}
                                </div>
                                <div class="text-[10px] text-slate-400">تاريخ الرفع: {{ $c['attachments']['payment_proof']['uploaded_at'] }}</div>
                                <button onclick="alert('تم فتح وتحميل: {{ $c['attachments']['payment_proof']['name'] }}')" class="w-full py-1 bg-slate-100 hover:bg-slate-200 text-slate-800 rounded font-bold text-[11px] text-center transition-colors">
                                    معاينة وتحميل PDF ⬇
                                </button>
                            </div>

                            <!-- Slot 4: Contract Notes & Remarks (مرفق ملاحظات العقد) -->
                            <div class="p-3 bg-white rounded-lg border border-slate-200 space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-bold text-amber-800 bg-amber-50 px-1.5 py-0.5 rounded">4. مرفق ملاحظات العقد</span>
                                    <span class="text-[10px] text-slate-400 font-mono">{{ $c['attachments']['notes_attachment']['size'] }}</span>
                                </div>
                                <div class="font-semibold text-slate-800 text-[11px] truncate" title="{{ $c['attachments']['notes_attachment']['name'] }}">
                                    📝 {{ $c['attachments']['notes_attachment']['name'] }}
                                </div>
                                <div class="text-[10px] text-slate-400">تاريخ الرفع: {{ $c['attachments']['notes_attachment']['uploaded_at'] }}</div>
                                <button onclick="alert('تم فتح وتحميل: {{ $c['attachments']['notes_attachment']['name'] }}')" class="w-full py-1 bg-slate-100 hover:bg-slate-200 text-slate-800 rounded font-bold text-[11px] text-center transition-colors">
                                    معاينة وتحميل PDF ⬇
                                </button>
                            </div>

                        </div>
                    </div>

                    <!-- 2. Sites & Systems Breakdown -->
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 space-y-2">
                        <b class="text-xs text-slate-900 block">📍 المواقع والأنظمة المشمولة بالصيانة:</b>
                        <div class="grid sm:grid-cols-2 gap-2 text-xs">
                            @foreach($c['sites'] as $s)
                                <div class="p-2.5 bg-white rounded-lg border border-slate-200">
                                    <b class="text-slate-900 block">{{ $s['name'] }}</b>
                                    <div class="text-[11px] text-slate-500 mt-0.5">المساحة: {{ $s['area'] }} • الأنظمة: {{ $s['systems'] }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- 3. Team & Inspection Schedule -->
                    <div class="grid sm:grid-cols-2 gap-3 text-xs">
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 space-y-1">
                            <b class="text-slate-900">👥 الفريق المكلف:</b>
                            <div class="text-slate-700 font-medium">المهندس الفاحص: {{ $c['engineer'] }} • المشرف: {{ $c['supervisor'] }}</div>
                            <div class="text-[11px] text-slate-500">إجمالي الأجهزة والنقاط المسجلة: {{ $c['equipment_count'] }} جهاز</div>
                        </div>

                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 space-y-1">
                            <b class="text-slate-900">📅 التواريخ والفحص الدوري:</b>
                            <div class="text-slate-700">تاريخ السريان: {{ $c['start_date'] }} إلى {{ $c['end_date'] }}</div>
                            <div class="text-[11px] text-slate-500">آخر فحص ميداني: {{ $c['last_visit'] }} • موعد الزيارة القادمة: {{ $c['next_visit'] }}</div>
                        </div>
                    </div>

                </div>

            </div>
        @endforeach

    </div>

    <script>
        function toggleNode(id) {
            const el = document.getElementById(id);
            const icon = document.getElementById('icon-' + id);
            if (el) {
                el.classList.toggle('hidden');
                if (icon) {
                    icon.innerText = el.classList.contains('hidden') ? '◀' : '▼';
                }
            }
        }

        function expandAll() {
            document.querySelectorAll('[id^="tree-body-"]').forEach(el => {
                el.classList.remove('hidden');
                const id = el.id;
                const icon = document.getElementById('icon-' + id);
                if (icon) icon.innerText = '▼';
            });
        }

        function collapseAll() {
            document.querySelectorAll('[id^="tree-body-"]').forEach(el => {
                el.classList.add('hidden');
                const id = el.id;
                const icon = document.getElementById('icon-' + id);
                if (icon) icon.innerText = '◀';
            });
        }

        function filterContracts(status) {
            document.querySelectorAll('.c-filter-btn').forEach(b => {
                b.classList.remove('bg-slate-900', 'text-white');
                b.classList.add('bg-slate-100', 'text-slate-700');
            });
            event.target.classList.add('bg-slate-900', 'text-white');

            document.querySelectorAll('.contract-card').forEach(card => {
                if (status === 'all' || card.getAttribute('data-status') === status) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>

@endsection
