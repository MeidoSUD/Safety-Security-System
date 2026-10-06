<!DOCTYPE html>
<html lang="ar" dir="rtl" class="h-full bg-slate-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>لوحة التحكم ERP | شركة نبيكو العربية للتشغيل والصيانة</title>
    <meta name="description" content="منظومة إدارة عقود الصيانة الدورية وعمليات السلامة الميدانية لشركة نبيكو العربية للتشغيل والصيانة.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            navy: '#0f172a',
                            slate: '#1e293b',
                            blue: '#2563eb',
                            emerald: '#059669',
                            amber: '#d97706',
                            rose: '#e11d48',
                            red: '#dc2626'
                        }
                    },
                    fontFamily: {
                        cairo: ['Cairo', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace']
                    }
                }
            }
        }
    </script>
    <style>
        * {
            font-family: 'Cairo', sans-serif;
        }
        .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        dialog[open] {
            animation: modalIn 0.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        dialog::backdrop {
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(4px);
        }
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.97) translateY(8px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
    </style>
</head>
<body class="h-full flex flex-col bg-slate-100 text-slate-800 antialiased selection:bg-slate-900 selection:text-white">

    <!-- TOP DEMO NOTICE & EMERGENCY HOTLINE BAR -->
    <div class="bg-slate-900 text-slate-300 text-xs py-2 px-4 border-b border-slate-800 flex flex-wrap items-center justify-between gap-2 z-50">
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400 font-bold border border-emerald-500/30">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                نسخة تجريبية تفاعلية (Demo Mode)
            </span>
            <span class="text-slate-400 font-medium">شركة نبيكو العربية للتشغيل والصيانة • معتمد من منصة سلامة والدفاع المدني السعودي 🇸🇦</span>
        </div>
        <div class="flex items-center gap-4 text-xs">
            <span class="text-slate-300">طوارئ العمليات 24/7: <b class="text-white font-mono">9200-NABICO</b></span>
            <a href="{{ route('home') }}" class="text-slate-300 hover:text-white flex items-center gap-1 bg-slate-800 px-2.5 py-1 rounded border border-slate-700">
                <span>← موقع الشركة التعريفي</span>
            </a>
        </div>
    </div>

    <!-- MAIN APP HEADER -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 gap-4">
                
                <!-- Brand & Logo -->
                <div class="flex items-center gap-4">
                    <a href="{{ route('dashboard.home') }}" class="flex items-center gap-3">
                        <img src="{{ asset('logo.png') }}" alt="شعار نبيكو العربية" class="h-12 w-auto object-contain">
                        <div>
                            <div class="text-base font-extrabold text-slate-900 leading-tight">شركة نبيكو العربية</div>
                            <div class="text-[11px] font-semibold text-slate-500">للتشغيل والصيانة • نظام ERP الميداني</div>
                        </div>
                    </a>
                </div>

                <!-- ROLE SWITCHER TABS (Core Requirement) -->
                <div class="hidden lg:flex items-center bg-slate-100 p-1.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 gap-1">
                    <button onclick="setRole('admin')" id="role-admin" class="role-btn active px-3 py-1.5 rounded-lg bg-slate-900 text-white shadow-sm transition-all flex items-center gap-1.5">
                        <span>👑</span>
                        <span>الإدارة العليا (Admin)</span>
                    </button>
                    <button onclick="setRole('manager')" id="role-manager" class="role-btn px-3 py-1.5 rounded-lg hover:text-slate-900 transition-all flex items-center gap-1.5">
                        <span>🏢</span>
                        <span>مدير العمليات والعقود</span>
                    </button>
                    <button onclick="setRole('supervisor')" id="role-supervisor" class="role-btn px-3 py-1.5 rounded-lg hover:text-slate-900 transition-all flex items-center gap-1.5">
                        <span>🛡️</span>
                        <span>مشرف الميدان</span>
                    </button>
                    <button onclick="setRole('technician')" id="role-technician" class="role-btn px-3 py-1.5 rounded-lg hover:text-slate-900 transition-all flex items-center gap-1.5">
                        <span>👷</span>
                        <span>الفني / التقني</span>
                    </button>
                    <button onclick="setRole('client')" id="role-client" class="role-btn px-3 py-1.5 rounded-lg hover:text-slate-900 transition-all flex items-center gap-1.5">
                        <span>🏫</span>
                        <span>بوابة العميل (مدرسة/مصنع)</span>
                    </button>
                </div>

                <!-- Right Utility: Actions & Notifications -->
                <div class="flex items-center gap-3">
                    
                    <!-- Notification Bell with Dropdown -->
                    <div class="relative">
                        <button onclick="toggleNotifications()" class="relative p-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-red-600 ring-2 ring-white"></span>
                        </button>

                        <!-- Notification Popover -->
                        <div id="notifications-popover" class="hidden absolute left-0 sm:right-0 mt-2 w-80 sm:w-96 bg-white rounded-2xl border border-slate-200 shadow-xl p-4 z-50 space-y-3">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                                <span class="font-bold text-xs text-slate-900">تنبيهات العقود والزيارات الميدانية (3)</span>
                                <span class="text-[10px] text-slate-400">اليوم</span>
                            </div>
                            <div class="space-y-2 text-xs">
                                <div class="p-2.5 bg-amber-50 rounded-xl border border-amber-200 flex items-start gap-2.5">
                                    <span class="text-amber-600 text-base">⚠️</span>
                                    <div>
                                        <b class="text-slate-900 block">عقد قارب على الانتهاء (متبقي 15 يومًا)</b>
                                        <span class="text-slate-600 text-[11px]">مجمع مدارس الأندلس الأهلية - الرياض</span>
                                    </div>
                                </div>
                                <div class="p-2.5 bg-red-50 rounded-xl border border-red-200 flex items-start gap-2.5">
                                    <span class="text-red-600 text-base">🚨</span>
                                    <div>
                                        <b class="text-slate-900 block">طلب صيانة طارئ: انخفاض ضغط مضخة</b>
                                        <span class="text-slate-600 text-[11px]">مصنع الخزف السعودي - المدينة الصناعية 2</span>
                                    </div>
                                </div>
                                <div class="p-2.5 bg-emerald-50 rounded-xl border border-emerald-200 flex items-start gap-2.5">
                                    <span class="text-emerald-600 text-base">✓</span>
                                    <div>
                                        <b class="text-slate-900 block">تم اعتماد تقرير الفحص وإصدار رخصة سلامة</b>
                                        <span class="text-slate-600 text-[11px]">مستودعات أجيليتي اللوجستية - جدة</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Button: New Contract / New Ticket -->
                    <button onclick="openModal('newContractModal')" class="hidden sm:flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition-all shadow-sm">
                        <span>+</span>
                        <span>إضافة عقد جديد</span>
                    </button>

                    <button onclick="openModal('newTicketModal')" class="flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white text-xs font-bold transition-all shadow-sm">
                        <span>🚨</span>
                        <span>طلب طارئ</span>
                    </button>

                </div>

            </div>

            <!-- Mobile Role Switcher Bar -->
            <div class="lg:hidden flex items-center overflow-x-auto py-2.5 border-t border-slate-100 gap-2 text-xs font-bold">
                <span class="text-slate-400 shrink-0 text-[11px]">الأدوار:</span>
                <button onclick="setRole('admin')" class="role-btn-m active px-2.5 py-1 rounded-md bg-slate-900 text-white shrink-0">الإدارة</button>
                <button onclick="setRole('manager')" class="role-btn-m px-2.5 py-1 rounded-md bg-slate-100 text-slate-700 shrink-0">العمليات</button>
                <button onclick="setRole('supervisor')" class="role-btn-m px-2.5 py-1 rounded-md bg-slate-100 text-slate-700 shrink-0">المشرف</button>
                <button onclick="setRole('technician')" class="role-btn-m px-2.5 py-1 rounded-md bg-slate-100 text-slate-700 shrink-0">الفني</button>
                <button onclick="setRole('client')" class="role-btn-m px-2.5 py-1 rounded-md bg-slate-100 text-slate-700 shrink-0">العميل</button>
            </div>

        </div>
    </header>

    <!-- MAIN BODY CONTAINER -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow flex flex-col gap-6">

        <!-- ACTIVE ROLE BANNER -->
        <div class="bg-white rounded-2xl border border-slate-200 p-4 sm:p-5 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div id="role-avatar" class="w-12 h-12 rounded-xl bg-slate-900 text-white flex items-center justify-center text-xl font-bold">
                    👑
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h1 id="role-title" class="text-lg font-bold text-slate-900">لوحة تحكم الإدارة العليا (Admin Management)</h1>
                        <span id="role-badge" class="px-2 py-0.5 bg-slate-100 text-slate-700 text-[11px] font-bold rounded border border-slate-200">صلاحيات كاملة</span>
                    </div>
                    <p id="role-desc" class="text-xs text-slate-500 mt-0.5">متابعة الأداء المالي، العقود السارية، والعمليات الميدانية لشركة نبيكو العربية عبر مدن المملكة.</p>
                </div>
            </div>

            <!-- Quick Filter & City Selector -->
            <div class="flex items-center gap-2 text-xs">
                <span class="text-slate-500 font-semibold">المنطقة:</span>
                <select id="region-filter" onchange="filterRegion(this.value)" class="bg-slate-50 border border-slate-300 rounded-lg px-3 py-1.5 font-bold text-slate-800 focus:outline-none focus:border-slate-900">
                    <option value="all">كافة مناطق المملكة (الرياض، جدة، الدمام، الجبيل)</option>
                    <option value="riyadh">منطقة الرياض (المقر الرئيسي)</option>
                    <option value="western">المنطقة الغربية (جدة، مكة، المدينة)</option>
                    <option value="eastern">المنطقة الشرقية (الدمام، الجبيل، الخبر)</option>
                </select>
            </div>
        </div>

        <!-- KEY METRICS GRID -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            
            <!-- Metric 1: Active Contracts -->
            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm space-y-1">
                <div class="flex items-center justify-between text-xs text-slate-500 font-medium">
                    <span>إجمالي العقود السارية</span>
                    <span class="text-emerald-600 font-bold">🟢 نشط</span>
                </div>
                <div class="text-2xl font-black text-slate-900 font-mono" id="stat-active">148</div>
                <div class="text-[11px] text-emerald-600 font-semibold flex items-center gap-1">
                    <span>↑ 12 عقد جديد هذا الشهر</span>
                </div>
            </div>

            <!-- Metric 2: Expiring Soon Contracts (Dynamic counter) -->
            <div class="bg-white p-4 rounded-xl border border-amber-200 bg-amber-50/40 shadow-sm space-y-1">
                <div class="flex items-center justify-between text-xs text-amber-800 font-medium">
                    <span>عقود شارفت على الانتهاء</span>
                    <span class="text-amber-600 font-bold">🟡 أقل من 30 يوم</span>
                </div>
                <div class="text-2xl font-black text-amber-700 font-mono" id="stat-expiring">9</div>
                <div class="text-[11px] text-amber-800 font-semibold flex items-center gap-1">
                    <span>⚠️ تتطلب إشعار التجديد الفوري</span>
                </div>
            </div>

            <!-- Metric 3: Overdue / Scheduled Visits -->
            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm space-y-1">
                <div class="flex items-center justify-between text-xs text-slate-500 font-medium">
                    <span>زيارات الفحص المجدولة</span>
                    <span class="text-blue-600 font-bold">📅 هذا الأسبوع</span>
                </div>
                <div class="text-2xl font-black text-slate-900 font-mono" id="stat-visits">34</div>
                <div class="text-[11px] text-slate-500 font-semibold">
                    <span>منها 3 زيارات طارئة اليوم</span>
                </div>
            </div>

            <!-- Metric 4: Open Maintenance Requests -->
            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm space-y-1">
                <div class="flex items-center justify-between text-xs text-slate-500 font-medium">
                    <span>طلبات الصيانة المفتوحة</span>
                    <span class="text-red-600 font-bold">🚨 قيد المعالجة</span>
                </div>
                <div class="text-2xl font-black text-red-600 font-mono" id="stat-tickets">6</div>
                <div class="text-[11px] text-slate-500 font-semibold">
                    <span>متوسط الاستجابة: 42 دقيقة</span>
                </div>
            </div>

            <!-- Metric 5: Pending Spare Parts / Invoices -->
            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm space-y-1 col-span-2 md:col-span-1">
                <div class="flex items-center justify-between text-xs text-slate-500 font-medium">
                    <span>مطالبات وقطع غيار معلقة</span>
                    <span class="text-slate-600 font-mono">ر.س</span>
                </div>
                <div class="text-2xl font-black text-slate-900 font-mono" id="stat-financial">142,500</div>
                <div class="text-[11px] text-emerald-700 font-semibold">
                    <span>88% نسبة التحصيل السنوي</span>
                </div>
            </div>

        </div>

        <!-- NAVIGATION TABS FOR CORE VIEWS -->
        <div class="bg-white rounded-xl border border-slate-200 p-1.5 flex flex-wrap gap-1 text-xs font-bold shadow-sm">
            <button onclick="switchView('tree')" id="tab-tree" class="view-tab active px-4 py-2 rounded-lg bg-slate-900 text-white transition-all flex items-center gap-2">
                <span>🌲</span>
                <span>شجرة العقود والمنشآت التفاعلية (Contract Hierarchy Tree)</span>
            </button>
            <button onclick="switchView('table')" id="tab-table" class="view-tab px-4 py-2 rounded-lg text-slate-600 hover:text-slate-900 transition-all flex items-center gap-2">
                <span>📋</span>
                <span>سجل العقود والمؤشرات الزمنية</span>
            </button>
            <button onclick="switchView('visits')" id="tab-visits" class="view-tab px-4 py-2 rounded-lg text-slate-600 hover:text-slate-900 transition-all flex items-center gap-2">
                <span>👷</span>
                <span>الزيارات الميدانية وجدول الفحص</span>
            </button>
            <button onclick="switchView('assets')" id="tab-assets" class="view-tab px-4 py-2 rounded-lg text-slate-600 hover:text-slate-900 transition-all flex items-center gap-2">
                <span>🧯</span>
                <span>سجل الأجهزة ومسح QR Code</span>
            </button>
            <button onclick="switchView('membership')" id="tab-membership" class="view-tab px-4 py-2 rounded-lg text-slate-600 hover:text-slate-900 transition-all flex items-center gap-2">
                <span>📥</span>
                <span>طابور طلبات التسجيل الجديدة (3)</span>
            </button>
        </div>

        <!-- ========================================== -->
        <!-- VIEW 1: CONTRACT HIERARCHY TREE VIEW       -->
        <!-- Contract → Sites → Services → Employees → Equipment → Tasks → Reports → Invoices -->
        <!-- ========================================== -->
        <div id="view-tree" class="view-section space-y-4">
            
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4 mb-6">
                    <div>
                        <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <span>🌲 هيكل الشجرة الإدارية الموحدة (Contract Hierarchy Tree)</span>
                            <span class="text-xs px-2 py-0.5 bg-blue-50 text-blue-700 rounded font-normal">نبيكو العربية ERP</span>
                        </h2>
                        <p class="text-xs text-slate-500 mt-1">
                            العقد (Contract) ← المواقع (Sites) ← الخدمات (Services) ← الموظفين (Staff) ← المعدات (Assets) ← المهام (Tasks) ← التقارير (Reports) ← الفواتير (Invoices)
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button onclick="expandAllTree()" class="px-3 py-1.5 rounded bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors">
                            توسيع الكل ⤢
                        </button>
                        <button onclick="collapseAllTree()" class="px-3 py-1.5 rounded bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors">
                            طي الكل ⤡
                        </button>
                    </div>
                </div>

                <!-- TREE ROOT 1: AL-ANDALUS SCHOOLS (RIYADH) -->
                <div class="border border-slate-200 rounded-xl p-4 mb-4 bg-slate-50/50 space-y-3 tree-node">
                    
                    <!-- Root Node Header: Contract -->
                    <div class="flex flex-wrap items-center justify-between gap-3 bg-white p-3.5 rounded-xl border border-slate-200 shadow-sm cursor-pointer" onclick="toggleTreeNode('tree-node-1')">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center font-bold text-sm">🎓</span>
                            <div>
                                <div class="flex items-center gap-2">
                                    <b class="text-sm text-slate-900">عقد صيانة دورية #NBC-2026-88: مجمع مدارس الأندلس الأهلية</b>
                                    <span class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                        🟡 قارب على الانتهاء (متبقي 18 يومًا)
                                    </span>
                                </div>
                                <div class="text-xs text-slate-500 flex gap-4 mt-0.5">
                                    <span>الرياض - حي النرجس</span>
                                    <span>•</span>
                                    <span>قيمة العقد: <b class="font-mono text-slate-800">65,000 ر.س / سنوياً</b></span>
                                    <span>•</span>
                                    <span>رخصة سلامة: <b class="text-emerald-600">سارية</b></span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <button onclick="event.stopPropagation(); renewContract('NBC-2026-88')" class="px-3 py-1.5 rounded-lg bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs">
                                🔄 تجديد العقد الفوري
                            </button>
                            <span id="icon-tree-node-1" class="text-slate-400 font-bold text-lg">▼</span>
                        </div>
                    </div>

                    <!-- Child Branches (Sites → Services → Employees → Equipment → Tasks → Reports → Invoices) -->
                    <div id="tree-node-1" class="pr-6 space-y-3 border-r-2 border-slate-300">
                        
                        <!-- Level 2: Sites -->
                        <div class="bg-white p-3 rounded-xl border border-slate-200 space-y-2">
                            <div class="flex items-center justify-between text-xs font-bold text-slate-800">
                                <span class="flex items-center gap-1.5 text-blue-800">
                                    <span>📍 المواقع والفروع المشمولة (2 موقع):</span>
                                </span>
                            </div>
                            <div class="grid sm:grid-cols-2 gap-2 text-xs">
                                <div class="p-2.5 bg-slate-50 rounded-lg border border-slate-100">
                                    <b>مبنى البنين الرئيسي (4 أدوار + صالة رياضية)</b>
                                    <div class="text-[11px] text-slate-500">المساحة: 4,800 م² • شبكة رش آلي متكاملة</div>
                                </div>
                                <div class="p-2.5 bg-slate-50 rounded-lg border border-slate-100">
                                    <b>مبنى الروضة والمرحلة الابتدائية (دورين)</b>
                                    <div class="text-[11px] text-slate-500">المساحة: 2,200 م² • كواشف دخان معنونة + مخارج طوارئ</div>
                                </div>
                            </div>
                        </div>

                        <!-- Level 3: Services & Scope -->
                        <div class="bg-white p-3 rounded-xl border border-slate-200 space-y-2">
                            <span class="text-xs font-bold text-purple-800 flex items-center gap-1.5">
                                <span>⚙️ الخدمات والأنظمة المغطاة (Scope of Services):</span>
                            </span>
                            <div class="flex flex-wrap gap-2 text-xs">
                                <span class="px-2.5 py-1 bg-slate-100 rounded-md border border-slate-200">فحص وصيانة مضخات الحريق ديزل وكهرباء (أسبوعي)</span>
                                <span class="px-2.5 py-1 bg-slate-100 rounded-md border border-slate-200">اختبار لوحة الإنذار Simplex المعنونة (شهري)</span>
                                <span class="px-2.5 py-1 bg-slate-100 rounded-md border border-slate-200">وزن واختبار ضغط 142 طفاية حريق (ربع سنوي)</span>
                                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-800 rounded-md border border-emerald-200 font-bold">رفع تقرير سلامة الدوري لمنصة الدفاع المدني</span>
                            </div>
                        </div>

                        <!-- Level 4: Assigned Employees & Engineers -->
                        <div class="bg-white p-3 rounded-xl border border-slate-200 space-y-2">
                            <span class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                                <span>👥 الفريق الهندسي المكلف من نبيكو:</span>
                            </span>
                            <div class="grid sm:grid-cols-2 gap-2 text-xs">
                                <div class="p-2 bg-slate-50 rounded border border-slate-100 flex items-center justify-between">
                                    <div>
                                        <b class="text-slate-900">م. طارق الشمري</b>
                                        <div class="text-[10px] text-slate-500">مهندس سلامة معتمد (الهيئة السعودية للمهندسين #5412)</div>
                                    </div>
                                    <span class="text-emerald-600 text-xs font-bold">مشرف الموقع</span>
                                </div>
                                <div class="p-2 bg-slate-50 rounded border border-slate-100 flex items-center justify-between">
                                    <div>
                                        <b class="text-slate-900">فني سالم الدوسري</b>
                                        <div class="text-[10px] text-slate-500">فني فحص شبكات إطفاء ومضخات</div>
                                    </div>
                                    <span class="text-blue-600 text-xs font-bold">الفني المنفذ</span>
                                </div>
                            </div>
                        </div>

                        <!-- Level 5: Equipment & Assets Log -->
                        <div class="bg-white p-3 rounded-xl border border-slate-200 space-y-2">
                            <div class="flex items-center justify-between text-xs font-bold text-slate-800">
                                <span>🧯 الأجهزة والمعدات المفحوصة (Assets Registered):</span>
                                <button onclick="openModal('qrScannerModal')" class="text-xs text-blue-700 hover:underline">
                                    مسح باركود QR للمعدات ←
                                </button>
                            </div>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-xs">
                                <div class="p-2 bg-slate-50 rounded text-center border border-slate-100">
                                    <span class="text-slate-500 text-[10px] block">طفايات بودرة 6 كجم</span>
                                    <b class="font-mono text-slate-900">118 طفاية (سليمة ✓)</b>
                                </div>
                                <div class="p-2 bg-slate-50 rounded text-center border border-slate-100">
                                    <span class="text-slate-500 text-[10px] block">طفايات ثاني أكسيد الكربون</span>
                                    <b class="font-mono text-slate-900">24 طفاية (سليمة ✓)</b>
                                </div>
                                <div class="p-2 bg-slate-50 rounded text-center border border-slate-100">
                                    <span class="text-slate-500 text-[10px] block">مضخات الحريق الرئيسية</span>
                                    <b class="font-mono text-emerald-700">2 مضخة (140 PSI)</b>
                                </div>
                                <div class="p-2 bg-slate-50 rounded text-center border border-slate-100">
                                    <span class="text-slate-500 text-[10px] block">صناديق خراطيم مطاطية</span>
                                    <b class="font-mono text-slate-900">16 صندوق (30 متر)</b>
                                </div>
                            </div>
                        </div>

                        <!-- Level 6 & 7: Tasks, Reports & Invoices -->
                        <div class="grid sm:grid-cols-2 gap-3">
                            <!-- Reports -->
                            <div class="bg-white p-3 rounded-xl border border-slate-200 text-xs space-y-2">
                                <b class="text-slate-900 flex items-center gap-1.5">
                                    <span>📄 التقارير ورخص الدفاع المدني:</span>
                                </b>
                                <div class="space-y-1 text-[11px] text-slate-600">
                                    <div class="flex justify-between p-1.5 bg-slate-50 rounded">
                                        <span>شهادة سلامة رقم #SLM-2026-9941</span>
                                        <button onclick="viewCertificate('مجمع مدارس الأندلس الأهلية', 'SLM-2026-9941')" class="text-blue-700 font-bold hover:underline">معاينة PDF</button>
                                    </div>
                                    <div class="flex justify-between p-1.5 bg-slate-50 rounded">
                                        <span>تقرير الزيارة الربع سنوية Q3</span>
                                        <span class="text-emerald-600 font-bold">معتمد وموقع ✓</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Invoices -->
                            <div class="bg-white p-3 rounded-xl border border-slate-200 text-xs space-y-2">
                                <b class="text-slate-900 flex items-center gap-1.5">
                                    <span>💳 الفواتير والمطالبات المالية:</span>
                                </b>
                                <div class="space-y-1 text-[11px] text-slate-600">
                                    <div class="flex justify-between p-1.5 bg-emerald-50 text-emerald-900 rounded">
                                        <span>دفعة التعاقد الأولى (الربع 1 و2)</span>
                                        <b class="font-mono">32,500 ر.س (مسددة ✓)</b>
                                    </div>
                                    <div class="flex justify-between p-1.5 bg-amber-50 text-amber-900 rounded">
                                        <span>دفعة صيانة الربع الثالث Q3</span>
                                        <b class="font-mono">16,250 ر.س (تستحق بعد 10 أيام)</b>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- TREE ROOT 2: SABIC PLASTIC FACTORY (DAMMAM INDUSTRIAL 2) -->
                <div class="border border-slate-200 rounded-xl p-4 mb-4 bg-slate-50/50 space-y-3 tree-node">
                    
                    <div class="flex flex-wrap items-center justify-between gap-3 bg-white p-3.5 rounded-xl border border-slate-200 shadow-sm cursor-pointer" onclick="toggleTreeNode('tree-node-2')">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-lg bg-orange-50 text-orange-700 flex items-center justify-center font-bold text-sm">🏭</span>
                            <div>
                                <div class="flex items-center gap-2">
                                    <b class="text-sm text-slate-900">عقد الصيانة الشامل #NBC-2026-104: مصنع الخزف والبلاستيك السعودي</b>
                                    <span class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        🟢 ساري (متبقي 284 يومًا)
                                    </span>
                                </div>
                                <div class="text-xs text-slate-500 flex gap-4 mt-0.5">
                                    <span>الدمام - المدينة الصناعية الثانية</span>
                                    <span>•</span>
                                    <span>قيمة العقد: <b class="font-mono text-slate-800">120,000 ر.س / سنوياً</b></span>
                                    <span>•</span>
                                    <span>أنظمة غاز FM200 وFoam Deluge</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-xs text-slate-500">الفحص القادم: 12 نوفمبر 2026</span>
                            <span id="icon-tree-node-2" class="text-slate-400 font-bold text-lg">▼</span>
                        </div>
                    </div>

                    <div id="tree-node-2" class="pr-6 space-y-3 border-r-2 border-slate-300">
                        <div class="bg-white p-3 rounded-xl border border-slate-200 text-xs text-slate-600">
                            <b>المعدات الخاصة:</b> 4 غرف محابس غمر رغوي (Foam Deluge) لخطوط البتروكيماويات • مضخة ديزل 750 GPM معتمدة • شبكة إنذار ضوئية وصوتية للبيئات الانفجارية (ATEX Certified).
                        </div>
                    </div>

                </div>

                <!-- TREE ROOT 3: AGILITY LOGISTICS WAREHOUSE (JEDDAH) -->
                <div class="border border-slate-200 rounded-xl p-4 bg-slate-50/50 space-y-3 tree-node">
                    
                    <div class="flex flex-wrap items-center justify-between gap-3 bg-white p-3.5 rounded-xl border border-slate-200 shadow-sm cursor-pointer" onclick="toggleTreeNode('tree-node-3')">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold text-sm">📦</span>
                            <div>
                                <div class="flex items-center gap-2">
                                    <b class="text-sm text-slate-900">عقد الصيانة والرخص #NBC-2026-119: مستودعات أجيليتي اللوجستية المركزية</b>
                                    <span class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        🟢 ساري (متبقي 192 يومًا)
                                    </span>
                                </div>
                                <div class="text-xs text-slate-500 flex gap-4 mt-0.5">
                                    <span>جدة - الخمرة اللوجستية</span>
                                    <span>•</span>
                                    <span>مساحة: 18,000 م²</span>
                                    <span>•</span>
                                    <span>كواشف شعاع ضوئي (Beam Detectors)</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-xs text-slate-500">الفحص القادم: 25 نوفمبر 2026</span>
                            <span id="icon-tree-node-3" class="text-slate-400 font-bold text-lg">▼</span>
                        </div>
                    </div>

                    <div id="tree-node-3" class="pr-6 space-y-3 border-r-2 border-slate-300 hidden">
                        <div class="bg-white p-3 rounded-xl border border-slate-200 text-xs text-slate-600">
                            <b>نطاق الفحص:</b> 28 كاشف شعاع ليزري للأسقف المرتفعة (12 متر) • شبكة رش آلي بنظام ESFR للتخزين العالي • 4 خزانات مياه سعة 150,000 لتر.
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <!-- ========================================== -->
        <!-- VIEW 2: CONTRACT STATUS TABLE VIEW         -->
        <!-- Dynamic indicators: 🟢 ساري, 🟡 قارب على الانتهاء, 🔴 منتهي -->
        <!-- ========================================== -->
        <div id="view-table" class="view-section hidden space-y-4">
            
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4 mb-4">
                    <div>
                        <h2 class="text-base font-bold text-slate-900">سجل عقود الصيانة الدورية الشاملة (AMC Management)</h2>
                        <p class="text-xs text-slate-500 mt-0.5">مؤشرات دقيقة للحالة الزمنية لكل عقد، تنبيهات التجديد، وربط رخص الدفاع المدني.</p>
                    </div>

                    <!-- Filter buttons -->
                    <div class="flex items-center gap-1.5 text-xs">
                        <button onclick="filterContractTable('all')" class="contract-filter-btn active px-3 py-1.5 rounded-lg bg-slate-900 text-white font-bold">الكل (148)</button>
                        <button onclick="filterContractTable('active')" class="contract-filter-btn px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 font-bold hover:bg-slate-200">🟢 ساري (134)</button>
                        <button onclick="filterContractTable('expiring')" class="contract-filter-btn px-3 py-1.5 rounded-lg bg-amber-100 text-amber-900 font-bold hover:bg-amber-200">🟡 قارب على الانتهاء (9)</button>
                        <button onclick="filterContractTable('expired')" class="contract-filter-btn px-3 py-1.5 rounded-lg bg-red-100 text-red-900 font-bold hover:bg-red-200">🔴 منتهي (5)</button>
                    </div>
                </div>

                <!-- Responsive Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-right text-xs">
                        <thead>
                            <tr class="bg-slate-50 text-slate-600 border-b border-slate-200 font-bold">
                                <th class="p-3">رقم العقد والمنشأة</th>
                                <th class="p-3">القطاع والمدينة</th>
                                <th class="p-3">الأنظمة المشمولة</th>
                                <th class="p-3">تاريخ البداية والانتهاء</th>
                                <th class="p-3">الحالة الزمنية والعداد</th>
                                <th class="p-3">رخصة سلامة</th>
                                <th class="p-3 text-center">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100" id="contract-table-body">
                            
                            <!-- Row 1: Expiring Soon -->
                            <tr class="hover:bg-slate-50/80 transition-colors contract-row" data-status="expiring">
                                <td class="p-3">
                                    <b class="text-slate-900 block">#NBC-2026-88</b>
                                    <span class="text-slate-600">مجمع مدارس الأندلس الأهلية</span>
                                </td>
                                <td class="p-3">
                                    <span class="px-2 py-0.5 bg-blue-50 text-blue-700 rounded text-[11px] font-semibold">مدرسة</span>
                                    <div class="text-slate-500 text-[11px] mt-0.5">الرياض - حي النرجس</div>
                                </td>
                                <td class="p-3 text-slate-600">رش آلي + إنذار معنون + مضخات ديزل</td>
                                <td class="p-3 font-mono text-[11px]">
                                    <div>01-11-2025</div>
                                    <div class="text-amber-700 font-bold">31-10-2026</div>
                                </td>
                                <td class="p-3">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-100 text-amber-900 border border-amber-300">
                                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                        متبقي 18 يومًا
                                    </span>
                                </td>
                                <td class="p-3">
                                    <span class="text-emerald-700 font-bold">سارية ✓</span>
                                </td>
                                <td class="p-3 text-center">
                                    <button onclick="renewContract('NBC-2026-88')" class="px-2.5 py-1 rounded bg-amber-600 hover:bg-amber-700 text-white font-bold text-[11px]">
                                        إشعار تجديد
                                    </button>
                                </td>
                            </tr>

                            <!-- Row 2: Active -->
                            <tr class="hover:bg-slate-50/80 transition-colors contract-row" data-status="active">
                                <td class="p-3">
                                    <b class="text-slate-900 block">#NBC-2026-104</b>
                                    <span class="text-slate-600">مصنع الخزف والبلاستيك السعودي</span>
                                </td>
                                <td class="p-3">
                                    <span class="px-2 py-0.5 bg-orange-50 text-orange-700 rounded text-[11px] font-semibold">مصنع</span>
                                    <div class="text-slate-500 text-[11px] mt-0.5">الدمام - المدينة الصناعية 2</div>
                                </td>
                                <td class="p-3 text-slate-600">غاز FM200 + Foam Deluge + مضخات 750 GPM</td>
                                <td class="p-3 font-mono text-[11px]">
                                    <div>15-07-2026</div>
                                    <div class="text-slate-700">14-07-2027</div>
                                </td>
                                <td class="p-3">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                        متبقي 284 يومًا
                                    </span>
                                </td>
                                <td class="p-3">
                                    <span class="text-emerald-700 font-bold">سارية ✓</span>
                                </td>
                                <td class="p-3 text-center">
                                    <button onclick="viewContractDetails('NBC-2026-104')" class="px-2.5 py-1 rounded bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-[11px]">
                                        تفاصيل العقد
                                    </button>
                                </td>
                            </tr>

                            <!-- Row 3: Active -->
                            <tr class="hover:bg-slate-50/80 transition-colors contract-row" data-status="active">
                                <td class="p-3">
                                    <b class="text-slate-900 block">#NBC-2026-119</b>
                                    <span class="text-slate-600">مستودعات أجيليتي اللوجستية المركزية</span>
                                </td>
                                <td class="p-3">
                                    <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 rounded text-[11px] font-semibold">مستودع</span>
                                    <div class="text-slate-500 text-[11px] mt-0.5">جدة - الخمرة اللوجستية</div>
                                </td>
                                <td class="p-3 text-slate-600">شبكة ESFR + كواشف شعاع ليزري Beam</td>
                                <td class="p-3 font-mono text-[11px]">
                                    <div>15-04-2026</div>
                                    <div class="text-slate-700">14-04-2027</div>
                                </td>
                                <td class="p-3">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                        متبقي 192 يومًا
                                    </span>
                                </td>
                                <td class="p-3">
                                    <span class="text-emerald-700 font-bold">سارية ✓</span>
                                </td>
                                <td class="p-3 text-center">
                                    <button onclick="viewContractDetails('NBC-2026-119')" class="px-2.5 py-1 rounded bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-[11px]">
                                        تفاصيل العقد
                                    </button>
                                </td>
                            </tr>

                            <!-- Row 4: Expired -->
                            <tr class="hover:bg-slate-50/80 transition-colors contract-row" data-status="expired">
                                <td class="p-3">
                                    <b class="text-slate-900 block">#NBC-2025-42</b>
                                    <span class="text-slate-600">مجمع دار الرعاية الطبي</span>
                                </td>
                                <td class="p-3">
                                    <span class="px-2 py-0.5 bg-purple-50 text-purple-700 rounded text-[11px] font-semibold">مستشفى</span>
                                    <div class="text-slate-500 text-[11px] mt-0.5">الرياض - حي الملز</div>
                                </td>
                                <td class="p-3 text-slate-600">إنذار ذكي + أبواب طوارئ مغناطيسية</td>
                                <td class="p-3 font-mono text-[11px]">
                                    <div>01-09-2025</div>
                                    <div class="text-red-700 font-bold">24-09-2026</div>
                                </td>
                                <td class="p-3">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-red-100 text-red-900 border border-red-300">
                                        <span class="w-2 h-2 rounded-full bg-red-600"></span>
                                        منتهي منذ 12 يومًا
                                    </span>
                                </td>
                                <td class="p-3">
                                    <span class="text-red-700 font-bold">⚠️ متوقفة</span>
                                </td>
                                <td class="p-3 text-center">
                                    <button onclick="renewContract('NBC-2025-42')" class="px-2.5 py-1 rounded bg-red-600 hover:bg-red-700 text-white font-bold text-[11px]">
                                        تجديد عاجل
                                    </button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

            </div>

        </div>

        <!-- ========================================== -->
        <!-- VIEW 3: FIELD VISITS & INSPECTION RADAR    -->
        <!-- ========================================== -->
        <div id="view-visits" class="view-section hidden space-y-4">
            
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <h2 class="text-base font-bold text-slate-900">جدول الزيارات الميدانية والفحص الدوري اليوم</h2>
                        <p class="text-xs text-slate-500">توزيع المهندسين والمشرفين مع إثبات الحضور الجغرافي (GPS Check-in).</p>
                    </div>
                    <button onclick="openModal('newTicketModal')" class="px-3.5 py-1.5 bg-slate-900 hover:bg-slate-800 text-white rounded-lg text-xs font-bold">
                        + جدولة زيارة جديدة
                    </button>
                </div>

                <div class="grid md:grid-cols-3 gap-4">
                    
                    <!-- Visit 1 -->
                    <div class="p-4 rounded-xl border border-amber-200 bg-amber-50/30 space-y-3">
                        <div class="flex justify-between items-center text-xs">
                            <span class="font-bold text-amber-900">زيارة طارئة #VST-991</span>
                            <span class="px-2 py-0.5 rounded bg-amber-100 text-amber-800 text-[10px] font-bold">قيد التنفيذ الآن</span>
                        </div>
                        <div>
                            <b class="text-slate-900 text-sm block">مصنع الخزف والبلاستيك السعودي</b>
                            <span class="text-xs text-slate-500">الدمام - المدينة الصناعية 2</span>
                        </div>
                        <div class="text-xs text-slate-600 bg-white p-2 rounded border border-slate-200 space-y-1">
                            <div>المهندس المكلف: <b>م. أحمد القحطاني</b></div>
                            <div>الهدف: فحص ضغط مضخة الحريق الديزل واختبار التسريب</div>
                        </div>
                        <button onclick="openChecklistModal('مصنع الخزف السعودي', 'م. أحمد القحطاني')" class="w-full py-2 bg-slate-900 hover:bg-slate-800 text-white rounded text-xs font-bold">
                            فتح استمارة الفحص الميداني 📋
                        </button>
                    </div>

                    <!-- Visit 2 -->
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 space-y-3">
                        <div class="flex justify-between items-center text-xs">
                            <span class="font-bold text-slate-700">فحص ربع سنوي Q3 #VST-992</span>
                            <span class="px-2 py-0.5 rounded bg-blue-100 text-blue-800 text-[10px] font-bold">مجدول: 02:00 م</span>
                        </div>
                        <div>
                            <b class="text-slate-900 text-sm block">مجمع مدارس الأندلس الأهلية</b>
                            <span class="text-xs text-slate-500">الرياض - حي النرجس</span>
                        </div>
                        <div class="text-xs text-slate-600 bg-white p-2 rounded border border-slate-200 space-y-1">
                            <div>المشرف الميداني: <b>سالم الدوسري</b></div>
                            <div>الهدف: مسح QR لـ 142 طفاية حريق وفحص كواشف الدخان</div>
                        </div>
                        <button onclick="openChecklistModal('مدارس الأندلس الأهلية', 'سالم الدوسري')" class="w-full py-2 bg-slate-900 hover:bg-slate-800 text-white rounded text-xs font-bold">
                            فتح استمارة الفحص الميداني 📋
                        </button>
                    </div>

                    <!-- Visit 3 -->
                    <div class="p-4 rounded-xl border border-emerald-200 bg-emerald-50/30 space-y-3">
                        <div class="flex justify-between items-center text-xs">
                            <span class="font-bold text-emerald-900">معاينة رخصة سلامة #VST-989</span>
                            <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 text-[10px] font-bold">مكتملة ومعتمدة ✓</span>
                        </div>
                        <div>
                            <b class="text-slate-900 text-sm block">مستودعات أجيليتي اللوجستية</b>
                            <span class="text-xs text-slate-500">جدة - الخمرة</span>
                        </div>
                        <div class="text-xs text-slate-600 bg-white p-2 rounded border border-slate-200 space-y-1">
                            <div>المهندس: <b>م. فيصل الغامدي</b></div>
                            <div>النتيجة: تم إصدار شهادة الكفاءة الفنية بنجاح</div>
                        </div>
                        <button onclick="viewCertificate('مستودعات أجيليتي اللوجستية', 'SLM-2026-119')" class="w-full py-2 bg-emerald-700 hover:bg-emerald-800 text-white rounded text-xs font-bold">
                            عرض شهادة الدفاع المدني PDF 📄
                        </button>
                    </div>

                </div>

            </div>

        </div>

        <!-- ========================================== -->
        <!-- VIEW 4: ASSETS & QR CODE SCANNING REGISTRY -->
        <!-- ========================================== -->
        <div id="view-assets" class="view-section hidden space-y-4">
            
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <h2 class="text-base font-bold text-slate-900">سجل الأجهزة ومعدات السلامة عبر QR Code</h2>
                        <p class="text-xs text-slate-500">تتبع باركود طفايات الحريق، صناديق الخراطيم، والمضخات في كافة المنشآت.</p>
                    </div>
                    <button onclick="openModal('qrScannerModal')" class="px-3.5 py-1.5 bg-blue-700 hover:bg-blue-800 text-white rounded-lg text-xs font-bold flex items-center gap-1.5">
                        <span>📷</span>
                        <span>محاكاة مسح QR كود</span>
                    </button>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 text-xs">
                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="font-mono text-slate-500">QR-EXT-8821</span>
                            <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 text-[10px] font-bold">سليمة ✓</span>
                        </div>
                        <b class="text-slate-900 block">طفاية بودرة 6 كجم ABC</b>
                        <div class="text-[11px] text-slate-500">الموقع: مدارس الأندلس - معمل الكيمياء</div>
                        <div class="text-[10px] text-slate-400">آخر فحص: اليوم 10:30 ص بواسطة سالم الدوسري</div>
                    </div>

                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="font-mono text-slate-500">QR-PUMP-401</span>
                            <span class="px-2 py-0.5 rounded bg-amber-100 text-amber-800 text-[10px] font-bold">صيانة دورية</span>
                        </div>
                        <b class="text-slate-900 block">مضخة حريق ديزل 500 GPM</b>
                        <div class="text-[11px] text-slate-500">الموقع: مصنع الخزف - غرفة المضخات</div>
                        <div class="text-[10px] text-slate-400">الضغط الحالي: 135 PSI • تم تغيير فلتر الزيت</div>
                    </div>

                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="font-mono text-slate-500">QR-PANEL-109</span>
                            <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 text-[10px] font-bold">سليمة ✓</span>
                        </div>
                        <b class="text-slate-900 block">لوحة إنذار Simplex 4100ES</b>
                        <div class="text-[11px] text-slate-500">الموقع: مستودعات أجيليتي - الإدارة</div>
                        <div class="text-[10px] text-slate-400">جميع الحلقات Loops تعمل بدون أي إنذار كاذب</div>
                    </div>

                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="font-mono text-slate-500">QR-HOSE-302</span>
                            <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 text-[10px] font-bold">سليمة ✓</span>
                        </div>
                        <b class="text-slate-900 block">صندوق حريق خرطوم مطاطي 30م</b>
                        <div class="text-[11px] text-slate-500">الموقع: مدارس الأندلس - الممر الشرقي</div>
                        <div class="text-[10px] text-slate-400">المحبس سليم • الخرطوم مختبر تحت الضغط</div>
                    </div>
                </div>

            </div>

        </div>

        <!-- ========================================== -->
        <!-- VIEW 5: MEMBERSHIP ONBOARDING QUEUE        -->
        <!-- ========================================== -->
        <div id="view-membership" class="view-section hidden space-y-4">
            
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <h2 class="text-base font-bold text-slate-900">طابور طلبات التسجيل والانضمام الجديدة (Onboarding Queue)</h2>
                        <p class="text-xs text-slate-500">طلبات المدارس والمصانع لفتح ملف منشأة وتوقيع عقد صيانة معتمد.</p>
                    </div>
                    <span class="px-2.5 py-1 bg-blue-50 text-blue-700 text-xs font-bold rounded-lg">3 طلبات جديدة</span>
                </div>

                <div class="space-y-3">
                    
                    <!-- App 1 -->
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <b class="text-sm text-slate-900">مدارس الفرسان العالمية - فرع العليا</b>
                                <span class="px-2 py-0.5 bg-blue-100 text-blue-800 text-[10px] font-bold rounded">مجمع تعليمي</span>
                                <span class="text-slate-400 text-xs">منذ ساعتين</span>
                            </div>
                            <div class="text-xs text-slate-600">
                                <span>المفوض: أ. عبدالمحسن الدوسري (0501112233)</span> • 
                                <span>المساحة: 6,500 م²</span> • 
                                <span>الخدمة: عقد صيانة سنوي AMC + تجديد رخصة سلامة</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button onclick="approveMembership(this, 'مدارس الفرسان العالمية')" class="px-3.5 py-2 bg-emerald-700 hover:bg-emerald-800 text-white rounded-lg text-xs font-bold">
                                اعتماد وفتح ملف فوراً ✓
                            </button>
                            <button class="px-3 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg text-xs font-bold">
                                تفاصيل الطلب
                            </button>
                        </div>
                    </div>

                    <!-- App 2 -->
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <b class="text-sm text-slate-900">مصنع الشرق للصناعات الكيماوية</b>
                                <span class="px-2 py-0.5 bg-orange-100 text-orange-800 text-[10px] font-bold rounded">مصنع كيميائي</span>
                                <span class="text-slate-400 text-xs">منذ 5 ساعات</span>
                            </div>
                            <div class="text-xs text-slate-600">
                                <span>الجبيل الصناعية</span> • 
                                <span>المفوض: م. خالد المنصور (0554443322)</span> • 
                                <span>الخدمة: شبكة رغوة فوم + رخصة مدن والدفاع المدني</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button onclick="approveMembership(this, 'مصنع الشرق للصناعات الكيماوية')" class="px-3.5 py-2 bg-emerald-700 hover:bg-emerald-800 text-white rounded-lg text-xs font-bold">
                                اعتماد وفتح ملف فوراً ✓
                            </button>
                            <button class="px-3 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg text-xs font-bold">
                                تفاصيل الطلب
                            </button>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- ========================================== -->
    <!-- MODAL 1: NEW CONTRACT MODAL                -->
    <!-- ========================================== -->
    <dialog id="newContractModal" class="rounded-2xl p-0 bg-white border border-slate-200 shadow-2xl max-w-xl w-full text-slate-800 m-auto overflow-hidden">
        <div class="p-6 space-y-4">
            <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                <b class="text-base text-slate-900">إضافة عقد صيانة دورية جديد (نبيكو ERP)</b>
                <button onclick="closeModal('newContractModal')" class="text-slate-400 hover:text-slate-900 p-1">✕</button>
            </div>
            <form onsubmit="handleNewContract(event)" class="space-y-3 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">اسم المنشأة / العميل *</label>
                    <input type="text" required placeholder="مثال: مجمع الرواد التعليمي" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-900 focus:outline-none focus:border-slate-900">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">نوع القطاع *</label>
                        <select class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-900">
                            <option>مدرسة / تعليمي</option>
                            <option>مصنع / صناعي</option>
                            <option>مستودع لوجستي</option>
                            <option>مستشفى / طبي</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">المدينة *</label>
                        <select class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-900">
                            <option>الرياض</option>
                            <option>جدة</option>
                            <option>الدمام</option>
                            <option>الجبيل</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">تاريخ بداية العقد *</label>
                        <input type="date" required value="2026-10-06" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-900">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">تاريخ نهاية العقد (سنة) *</label>
                        <input type="date" required value="2027-10-05" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-900">
                    </div>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">قيمة العقد السنوية (ر.س) *</label>
                    <input type="number" required placeholder="45000" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-900 font-mono">
                </div>
                <div class="pt-2">
                    <button type="submit" class="w-full py-3 bg-slate-900 hover:bg-slate-800 text-white rounded-lg font-bold text-xs">
                        حفظ العقد وإدراجه في الشجرة الميدانية ✓
                    </button>
                </div>
            </form>
        </div>
    </dialog>

    <!-- ========================================== -->
    <!-- MODAL 2: EMERGENCY VISIT TICKET MODAL      -->
    <!-- ========================================== -->
    <dialog id="newTicketModal" class="rounded-2xl p-0 bg-white border border-slate-200 shadow-2xl max-w-lg w-full text-slate-800 m-auto overflow-hidden">
        <div class="p-6 space-y-4">
            <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                <b class="text-base text-red-600 flex items-center gap-1.5">
                    <span>🚨</span>
                    <span>طلب صيانة أو فحص طارئ (Emergency Ticket)</span>
                </b>
                <button onclick="closeModal('newTicketModal')" class="text-slate-400 hover:text-slate-900 p-1">✕</button>
            </div>
            <form onsubmit="handleNewTicket(event)" class="space-y-3 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">اختر المنشأة *</label>
                    <select class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-900 font-bold">
                        <option>مجمع مدارس الأندلس الأهلية - الرياض</option>
                        <option>مصنع الخزف والبلاستيك السعودي - الدمام</option>
                        <option>مستودعات أجيليتي اللوجستية - جدة</option>
                        <option>مجمع دار الرعاية الطبي - الرياض</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">نوع البلاغ والعطل *</label>
                    <select class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-900">
                        <option>تسريب مياه في شبكة الرش الآلي (Sprinklers Leak)</option>
                        <option>انخفاض مفاجئ في ضغط مضخة الحريق الرئيسية (Low PSI)</option>
                        <option>إنذار متكرر أو عطل في لوحة الإنذار المعنونة (Fire Alarm Trouble)</option>
                        <option>فحص عاجل قبل زيارة مفتش الدفاع المدني</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">ملاحظات البلاغ وموقع العطل الدقيق</label>
                    <textarea rows="2" placeholder="الدور الثاني، معمل الفيزياء، تسريب عند المحبس الرئيسي..." class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-xs text-slate-900"></textarea>
                </div>
                <div class="pt-2">
                    <button type="submit" class="w-full py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-bold text-xs shadow">
                        إرسال البلاغ وتوجيه أقرب فني ميداني فوراً (خلال 30 دقيقة)
                    </button>
                </div>
            </form>
        </div>
    </dialog>

    <!-- ========================================== -->
    <!-- MODAL 3: CERTIFICATE / SLM VIEWER MODAL    -->
    <!-- ========================================== -->
    <dialog id="certViewerModal" class="rounded-2xl p-0 bg-white border border-slate-200 shadow-2xl max-w-lg w-full text-slate-800 m-auto overflow-hidden">
        <div class="p-6 space-y-4">
            <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                <b class="text-sm text-slate-900 flex items-center gap-1.5">
                    <span>🇸🇦</span>
                    <span>شهادة كفاءة السلامة المعتمدة (منصة سلامة)</span>
                </b>
                <button onclick="closeModal('certViewerModal')" class="text-slate-400 hover:text-slate-900 p-1">✕</button>
            </div>
            
            <div class="p-5 border-2 border-emerald-600 rounded-xl bg-slate-50 space-y-3 text-center">
                <div class="text-xs font-bold text-emerald-800">المملكة العربية السعودية • المديرية العامة للدفاع المدني</div>
                <h3 class="text-base font-extrabold text-slate-900" id="cert-facility-name">مجمع مدارس الأندلس الأهلية</h3>
                <div class="text-xs text-slate-600">
                    تشهد <b>شركة نبيكو العربية للتشغيل والصيانة</b> بجاهزية وكفاءة أنظمة الإطفاء والإنذار بالمنشأة ومطابقتها لكود البناء السعودي SBC 801.
                </div>
                <div class="py-2 border-y border-slate-200 grid grid-cols-2 gap-2 text-xs font-mono">
                    <div>رقم الشهادة: <b class="text-slate-900" id="cert-num">SLM-9941</b></div>
                    <div>تاريخ السريان: <b class="text-emerald-700">سارية حتى 2027</b></div>
                </div>
                <div class="text-[11px] text-slate-500">تم الاعتماد إلكترونياً عبر منصة سلامة الحكومية ✓</div>
            </div>

            <div class="flex gap-2">
                <button onclick="alert('تم تنزيل الشهادة بصيغة PDF بنجاح')" class="flex-1 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-lg font-bold text-xs">
                    تحميل الشهادة PDF ⬇
                </button>
                <button onclick="closeModal('certViewerModal')" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-bold text-xs">
                    إغلاق
                </button>
            </div>
        </div>
    </dialog>

    <!-- ========================================== -->
    <!-- MODAL 4: QR CODE SCANNER SIMULATOR        -->
    <!-- ========================================== -->
    <dialog id="qrScannerModal" class="rounded-2xl p-0 bg-white border border-slate-200 shadow-2xl max-w-sm w-full text-slate-800 m-auto overflow-hidden">
        <div class="p-6 text-center space-y-4">
            <div class="flex justify-between items-center border-b border-slate-100 pb-2">
                <b class="text-xs text-slate-900">محاكاة مسح QR كود للمعدات</b>
                <button onclick="closeModal('qrScannerModal')" class="text-slate-400 p-1">✕</button>
            </div>
            
            <div class="w-48 h-48 mx-auto bg-slate-950 rounded-2xl flex items-center justify-center text-emerald-400 border-2 border-dashed border-emerald-500 relative overflow-hidden">
                <div class="w-full h-0.5 bg-emerald-400 absolute top-1/2 left-0 animate-pulse"></div>
                <span class="text-4xl">📷</span>
            </div>

            <div class="text-xs text-slate-600">
                تم مسح الكود: <b class="font-mono text-slate-900">QR-EXT-8821</b><br>
                طفاية بودرة 6 كجم - مدارس الأندلس
            </div>

            <button onclick="alert('تم توثيق فحص الطفاية بنجاح وتسجيل الحالة: سليمة 100%'); closeModal('qrScannerModal');" class="w-full py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-lg font-bold text-xs">
                تأكيد الفحص وتسجيل القراءة ✓
            </button>
        </div>
    </dialog>

    <!-- ========================================== -->
    <!-- MODAL 5: INSPECTION CHECKLIST MODAL        -->
    <!-- ========================================== -->
    <dialog id="checklistModal" class="rounded-2xl p-0 bg-white border border-slate-200 shadow-2xl max-w-lg w-full text-slate-800 m-auto overflow-hidden">
        <div class="p-6 space-y-4">
            <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                <div>
                    <b class="text-sm text-slate-900 block" id="chk-title">استمارة الفحص الميداني الرقمية</b>
                    <span class="text-xs text-slate-500" id="chk-engineer">م. أحمد القحطاني</span>
                </div>
                <button onclick="closeModal('checklistModal')" class="text-slate-400 hover:text-slate-900 p-1">✕</button>
            </div>

            <div class="space-y-2 text-xs">
                <label class="flex items-center gap-2 p-2.5 bg-slate-50 rounded-lg border border-slate-200 cursor-pointer">
                    <input type="checkbox" checked class="rounded text-slate-900">
                    <span>فحص ضغط شبكة الرش الآلي (Pressure: 140 PSI)</span>
                </label>
                <label class="flex items-center gap-2 p-2.5 bg-slate-50 rounded-lg border border-slate-200 cursor-pointer">
                    <input type="checkbox" checked class="rounded text-slate-900">
                    <span>اختبار مضخة الديزل التلقائية وتشغيل مفتاح التدفق</span>
                </label>
                <label class="flex items-center gap-2 p-2.5 bg-slate-50 rounded-lg border border-slate-200 cursor-pointer">
                    <input type="checkbox" checked class="rounded text-slate-900">
                    <span>فحص بطاريات لوحة الإنذار والجهد الكهربائي (24V DC)</span>
                </label>
                <label class="flex items-center gap-2 p-2.5 bg-slate-50 rounded-lg border border-slate-200 cursor-pointer">
                    <input type="checkbox" checked class="rounded text-slate-900">
                    <span>معاينة سلامة خراطيم ومحابس الإطفاء اليدوية</span>
                </label>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">ملاحظة المهندس الفنية المعتمدة:</label>
                <textarea rows="2" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-2 text-xs text-slate-900">تم إجراء الفحص الشامل واختبار المضخة، النظام يعمل بكفاءة تامة وجاهز لتجديد رخصة الدفاع المدني.</textarea>
            </div>

            <div class="flex gap-2 pt-2">
                <button onclick="alert('تم اعتماد تقرير الفحص الميداني بنجاح وإرسال الإشعار للعميل'); closeModal('checklistModal');" class="flex-1 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-lg font-bold text-xs">
                    اعتماد التقرير وتوقيعه رقمياً ✓
                </button>
            </div>
        </div>
    </dialog>

    <!-- TOAST NOTIFICATION -->
    <div id="toast" class="fixed bottom-6 left-6 z-50 transform translate-y-32 opacity-0 transition-all duration-300 max-w-sm w-full bg-slate-900 text-white rounded-xl p-4 shadow-2xl flex items-center gap-3 border border-slate-700">
        <span class="text-emerald-400 text-xl font-bold">✓</span>
        <div class="flex-1 text-xs">
            <b class="block text-white" id="toast-title">تمت العملية</b>
            <span class="text-slate-300" id="toast-desc">تفاصيل الإجراء</span>
        </div>
    </div>

    <!-- JAVASCRIPT LOGIC -->
    <script>
        // Role Data & Config
        const rolesConfig = {
            admin: {
                title: 'لوحة تحكم الإدارة العليا (Admin Management)',
                badge: 'صلاحيات كاملة',
                desc: 'متابعة الأداء المالي، العقود السارية، والعمليات الميدانية لشركة نبيكو العربية عبر مدن المملكة.',
                avatar: '👑',
                activeContracts: 148,
                expiringContracts: 9,
                visits: 34,
                tickets: 6,
                financial: '142,500'
            },
            manager: {
                title: 'لوحة مدير العمليات والعقود (Operations & Contracts)',
                badge: 'إدارة التشغيل',
                desc: 'متابعة شجرة العقود، جدولة الزيارات، توزيع المهام على المهندسين، وتجديد رخص سلامة.',
                avatar: '🏢',
                activeContracts: 148,
                expiringContracts: 9,
                visits: 34,
                tickets: 4,
                financial: '85,000'
            },
            supervisor: {
                title: 'بوابة مشرف الميدان والفنيين (Field Supervisor)',
                badge: 'الإشراف الميداني',
                desc: 'متابعة جولات التفتيش، فحص طفايات الحريق عبر QR Code، وتوثيق الحضور بمواقع العملاء.',
                avatar: '🛡️',
                activeContracts: 42,
                expiringContracts: 3,
                visits: 14,
                tickets: 3,
                financial: '22,000'
            },
            technician: {
                title: 'بوابة الفني والتقني الميداني (Field Technician)',
                badge: 'المهام والزيارات',
                desc: 'استعراض الزيارات المجدولة لليوم، تسجيل قراءات ضغط المضخات PSI، وتعبئة استمارات الفحص.',
                avatar: '👷',
                activeContracts: 12,
                expiringContracts: 1,
                visits: 4,
                tickets: 2,
                financial: '0'
            },
            client: {
                title: 'بوابة العميل والمنشأة (مجمع مدارس الأندلس الأهلية)',
                badge: 'حساب المنشأة',
                desc: 'استعراض عقد الصيانة السنوي #NBC-2026-88، تحميل شهادات الدفاع المدني، وطلب زيارة طارئة.',
                avatar: '🏫',
                activeContracts: 1,
                expiringContracts: 1,
                visits: 1,
                tickets: 0,
                financial: '16,250'
            }
        };

        // Switch Active Role
        function setRole(roleKey) {
            const config = rolesConfig[roleKey];
            if (!config) return;

            // Update Header Buttons
            document.querySelectorAll('.role-btn').forEach(btn => {
                btn.className = 'role-btn px-3 py-1.5 rounded-lg hover:text-slate-900 transition-all flex items-center gap-1.5';
            });
            const activeBtn = document.getElementById(`role-${roleKey}`);
            if (activeBtn) {
                activeBtn.className = 'role-btn active px-3 py-1.5 rounded-lg bg-slate-900 text-white shadow-sm transition-all flex items-center gap-1.5';
            }

            // Update Mobile Buttons
            document.querySelectorAll('.role-btn-m').forEach(btn => {
                btn.className = 'role-btn-m px-2.5 py-1 rounded-md bg-slate-100 text-slate-700 shrink-0';
            });

            // Update Banner
            document.getElementById('role-title').innerText = config.title;
            document.getElementById('role-badge').innerText = config.badge;
            document.getElementById('role-desc').innerText = config.desc;
            document.getElementById('role-avatar').innerText = config.avatar;

            // Update Metrics
            document.getElementById('stat-active').innerText = config.activeContracts;
            document.getElementById('stat-expiring').innerText = config.expiringContracts;
            document.getElementById('stat-visits').innerText = config.visits;
            document.getElementById('stat-tickets').innerText = config.tickets;
            document.getElementById('stat-financial').innerText = config.financial;

            showToast('تم تبديل الدور', `أنت تتصفح النظام الآن بصلاحيات: ${config.title}`);
        }

        // Switch View Tab
        function switchView(viewKey) {
            document.querySelectorAll('.view-tab').forEach(t => {
                t.className = 'view-tab px-4 py-2 rounded-lg text-slate-600 hover:text-slate-900 transition-all flex items-center gap-2';
            });
            const activeTab = document.getElementById(`tab-${viewKey}`);
            if (activeTab) {
                activeTab.className = 'view-tab active px-4 py-2 rounded-lg bg-slate-900 text-white transition-all flex items-center gap-2';
            }

            document.querySelectorAll('.view-section').forEach(sec => sec.classList.add('hidden'));
            const target = document.getElementById(`view-${viewKey}`);
            if (target) {
                target.classList.remove('hidden');
            }
        }

        // Tree Toggle Node
        function toggleTreeNode(id) {
            const el = document.getElementById(id);
            const icon = document.getElementById(`icon-${id}`);
            if (el) {
                el.classList.toggle('hidden');
                if (icon) {
                    icon.innerText = el.classList.contains('hidden') ? '◀' : '▼';
                }
            }
        }

        function expandAllTree() {
            ['tree-node-1', 'tree-node-2', 'tree-node-3'].forEach(id => {
                const el = document.getElementById(id);
                const icon = document.getElementById(`icon-${id}`);
                if (el) el.classList.remove('hidden');
                if (icon) icon.innerText = '▼';
            });
        }

        function collapseAllTree() {
            ['tree-node-1', 'tree-node-2', 'tree-node-3'].forEach(id => {
                const el = document.getElementById(id);
                const icon = document.getElementById(`icon-${id}`);
                if (el) el.classList.add('hidden');
                if (icon) icon.innerText = '◀';
            });
        }

        // Filter Contracts Table
        function filterContractTable(status) {
            document.querySelectorAll('.contract-filter-btn').forEach(btn => {
                btn.classList.remove('bg-slate-900', 'text-white');
                btn.classList.add('bg-slate-100', 'text-slate-700');
            });
            event.target.classList.add('bg-slate-900', 'text-white');

            const rows = document.querySelectorAll('.contract-row');
            rows.forEach(r => {
                if (status === 'all' || r.getAttribute('data-status') === status) {
                    r.style.display = '';
                } else {
                    r.style.display = 'none';
                }
            });
        }

        // Notifications Popover
        function toggleNotifications() {
            const popover = document.getElementById('notifications-popover');
            popover.classList.toggle('hidden');
        }

        // Modals
        function openModal(id) {
            const modal = document.getElementById(id);
            if (modal) modal.showModal();
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            if (modal) modal.close();
        }

        function viewCertificate(facility, certNum) {
            document.getElementById('cert-facility-name').innerText = facility;
            document.getElementById('cert-num').innerText = certNum;
            openModal('certViewerModal');
        }

        function openChecklistModal(facility, engineer) {
            document.getElementById('chk-title').innerText = 'استمارة الفحص الميداني: ' + facility;
            document.getElementById('chk-engineer').innerText = 'المهندس الفاحص: ' + engineer;
            openModal('checklistModal');
        }

        function renewContract(contractNum) {
            alert(`تم إنشاء مسودة تجديد العقد #${contractNum} وإرسال إشعار لمنصة سلامة والعميل.`);
        }

        function viewContractDetails(contractNum) {
            switchView('tree');
            showToast('تم فتح تفاصيل العقد', `عقد رقم #${contractNum}`);
        }

        function approveMembership(btn, facilityName) {
            btn.parentElement.innerHTML = '<span class="text-emerald-700 font-bold text-xs">تم الاعتماد وفتح الملف الرقمي بنجاح ✓</span>';
            showToast('تم اعتماد المنشأة', `تم إدراج منشأة "${facilityName}" في شجرة العقود.`);
        }

        function handleNewContract(e) {
            e.preventDefault();
            closeModal('newContractModal');
            showToast('تمت إضافة العقد بنجاح', 'تم تسجيل العقد الجديد وتعيين مهندس الموقع.');
        }

        function handleNewTicket(e) {
            e.preventDefault();
            closeModal('newTicketModal');
            showToast('تم إرسال بلاغ الصيانة الطارئ', 'تم توجيه أقرب فريق فني لموقع المنشأة.');
        }

        function filterRegion(val) {
            showToast('تصفية المنطقة', `تم تحديث البيانات لمنطقة: ${val}`);
        }

        function showToast(title, desc) {
            const toast = document.getElementById('toast');
            document.getElementById('toast-title').innerText = title;
            document.getElementById('toast-desc').innerText = desc;

            toast.classList.remove('translate-y-32', 'opacity-0');
            toast.classList.add('translate-y-0', 'opacity-100');

            setTimeout(() => {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-32', 'opacity-0');
            }, 3500);
        }
    </script>
</body>
</html>
