<!DOCTYPE html>
<html lang="ar" dir="rtl" class="h-full bg-slate-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>@yield('title', 'لوحة تحكم ERP | شركة نبيكو العربية للتشغيل والصيانة')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
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
            -webkit-tap-highlight-color: transparent;
        }
        .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
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
        /* Mobile drawer animation */
        #mobile-sidebar.open {
            transform: translateX(0);
        }
    </style>
</head>
<body class="h-full flex flex-col lg:flex-row bg-slate-100 text-slate-800 antialiased selection:bg-slate-900 selection:text-white overflow-hidden relative">

    <!-- MOBILE SIDEBAR BACKDROP -->
    <div id="sidebar-backdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-950/70 z-40 hidden lg:hidden backdrop-blur-sm transition-opacity"></div>

    <!-- RIGHT SIDEBAR (Responsive Mobile Drawer + Desktop Fixed) -->
    <aside id="mobile-sidebar" class="fixed inset-y-0 right-0 z-50 w-72 lg:w-72 bg-slate-900 text-slate-300 flex flex-col shrink-0 border-l border-slate-800 select-none transform translate-x-full lg:translate-x-0 lg:static transition-transform duration-300 ease-in-out shadow-2xl lg:shadow-none">
        
        <!-- Sidebar Brand Header -->
        <div class="h-20 flex items-center justify-between px-6 border-b border-slate-800 bg-slate-950/70">
            <div class="flex items-center gap-3">
                <img src="{{ asset('logo.png') }}" alt="نبيكو العربية" class="h-10 w-auto object-contain">
                <div>
                    <div class="text-sm font-extrabold text-white leading-tight">شركة نبيكو العربية</div>
                    <div class="text-[10px] text-slate-400 font-semibold">للتشغيل والصيانة • نظام ERP</div>
                </div>
            </div>

            <!-- Close button on mobile -->
            <button onclick="toggleSidebar()" class="lg:hidden p-1.5 rounded-lg bg-slate-800 text-slate-400 hover:text-white">
                ✕
            </button>
        </div>

        <!-- Active User Profile Box in Sidebar -->
        @php
            $currentUser = session('user', [
                'role' => 'admin',
                'name' => 'م. عبدالرحمن المنصور',
                'title' => 'المدير التنفيذي (Admin)',
                'avatar' => '👑',
                'email' => 'admin@nabico.sa',
            ]);
        @endphp
        <div class="p-4 mx-4 my-3 bg-slate-800/80 rounded-xl border border-slate-700/60 space-y-2">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-slate-700 flex items-center justify-center text-lg font-bold shrink-0">
                    {{ $currentUser['avatar'] }}
                </div>
                <div class="overflow-hidden">
                    <div class="text-xs font-bold text-white truncate">{{ $currentUser['name'] }}</div>
                    <div class="text-[11px] text-emerald-400 font-semibold truncate">{{ $currentUser['title'] }}</div>
                </div>
            </div>
            
            <!-- Quick Role Switcher Inside Profile Box -->
            <form action="{{ route('switch.role') }}" method="POST" class="pt-1">
                @csrf
                <select name="role" onchange="this.form.submit()" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-2.5 py-1.5 text-[11px] text-slate-300 font-bold focus:outline-none focus:border-slate-500">
                    <option value="admin" {{ $currentUser['role'] === 'admin' ? 'selected' : '' }}>👑 الأدمن / الإدارة العليا</option>
                    <option value="manager" {{ $currentUser['role'] === 'manager' ? 'selected' : '' }}>🏢 مدير العمليات والعقود</option>
                    <option value="supervisor" {{ $currentUser['role'] === 'supervisor' ? 'selected' : '' }}>🛡️ مشرف الميدان والفنيين</option>
                    <option value="technician" {{ $currentUser['role'] === 'technician' ? 'selected' : '' }}>👷 الفني / التقني</option>
                    <option value="client" {{ $currentUser['role'] === 'client' ? 'selected' : '' }}>🏫 العميل (مدرسة/مصنع)</option>
                </select>
            </form>
        </div>

        <!-- Sidebar Navigation Menu (All Options Included) -->
        <nav class="flex-1 px-3 space-y-1 overflow-y-auto text-xs font-bold">
            
            <!-- 1. Dashboard Overview -->
            <a href="{{ route('dashboard.home') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('dashboard.home') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <span class="text-base">📊</span>
                    <span>الرئيسية والإحصائيات</span>
                </div>
            </a>

            <!-- 2. Contracts & Attachments & Sensitivity -->
            <a href="{{ route('dashboard.contracts') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('dashboard.contracts') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <span class="text-base">🌲</span>
                    <span>إدارة العقود والمرفقات</span>
                </div>
                <span class="px-2 py-0.5 rounded-full text-[10px] bg-slate-800 text-slate-400 font-mono">148</span>
            </a>

            <!-- 3. Visits, Zone Pricing & Spare Parts Alerts -->
            <a href="{{ route('dashboard.visits') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('dashboard.visits') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <span class="text-base">👷</span>
                    <span>الزيارات وتسعير النطاق</span>
                </div>
                <span class="px-2 py-0.5 rounded-full text-[10px] bg-amber-500/20 text-amber-300 font-bold font-mono">تنبيهات (2)</span>
            </a>

            <!-- 4. Reports & Template Customization -->
            <a href="{{ route('dashboard.reports') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('dashboard.reports') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <span class="text-base">📝</span>
                    <span>نماذج وتقارير الفحص</span>
                </div>
            </a>

            <!-- 5. Inter-Departmental Maintenance Requests -->
            <a href="{{ route('dashboard.internal_requests') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('dashboard.internal_requests') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <span class="text-base">🔄</span>
                    <span>طلبات بين إدارات الشركة</span>
                </div>
                <span class="px-2 py-0.5 rounded-full text-[10px] bg-purple-500/20 text-purple-300 font-bold font-mono">4</span>
            </a>

            <!-- 6. Membership & Onboarding Requests -->
            <a href="{{ route('dashboard.memberships') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('dashboard.memberships') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <span class="text-base">📥</span>
                    <span>طلبات التسجيل الجديدة</span>
                </div>
                <span class="px-2 py-0.5 rounded-full text-[10px] bg-emerald-500/20 text-emerald-400 font-bold font-mono">3</span>
            </a>

            <!-- 7. Role & Permission Management -->
            <a href="{{ route('dashboard.permissions') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('dashboard.permissions') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <span class="text-base">⚙️</span>
                    <span>إدارة الصلاحيات والأدوار</span>
                </div>
            </a>

        </nav>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-slate-800 bg-slate-950/70 space-y-2 text-xs">
            <a href="{{ route('home') }}" class="flex items-center gap-2 p-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors">
                <span>🌐</span>
                <span>الموقع التعريفي الرئيسي</span>
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 p-2 rounded-lg text-red-400 hover:text-red-300 hover:bg-red-950/30 transition-colors font-bold text-xs">
                    <span>🚪</span>
                    <span>تسجيل الخروج</span>
                </button>
            </form>
        </div>

    </aside>

    <!-- MAIN APP CONTENT AREA (Scrollable, Full-Width on Mobile) -->
    <div class="flex-1 flex flex-col min-w-0 h-full overflow-y-auto pb-16 lg:pb-0">
        
        <!-- Top App Bar (Responsive Header) -->
        <header class="h-16 sm:h-20 bg-white border-b border-slate-200 px-4 sm:px-8 flex items-center justify-between shrink-0 shadow-sm sticky top-0 z-30">
            
            <!-- Mobile Menu Toggle Button + Page Title -->
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 focus:outline-none transition-colors" aria-label="القائمة">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>

                <div>
                    <h1 class="text-sm sm:text-lg font-bold text-slate-900 leading-tight">
                        @yield('page_title', 'لوحة التحكم')
                    </h1>
                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 font-bold inline-block sm:hidden">
                        ● متصل بسلامة
                    </span>
                </div>
            </div>

            <!-- Header Right Controls -->
            <div class="flex items-center gap-2 sm:gap-3">
                
                <!-- Quick Role Switch Pill -->
                <div class="hidden md:flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                    <span class="text-slate-400">الحساب:</span>
                    <span class="font-bold text-slate-900">{{ $currentUser['title'] }}</span>
                </div>

                <!-- Emergency Contact Badge -->
                <a href="tel:920000000" class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-red-50 hover:bg-red-100 text-red-700 border border-red-200 text-xs font-bold font-mono transition-colors">
                    <span>🚨</span>
                    <span class="hidden sm:inline">طوارئ:</span>
                    <span>9200-NABICO</span>
                </a>

            </div>

        </header>

        <!-- Flash Message Alerts -->
        @if(session('success'))
            <div class="mx-4 sm:mx-8 mt-4 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs font-bold flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="text-base">✓</span>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900 font-bold">✕</button>
            </div>
        @endif

        <!-- Main View Content (Responsive Padding) -->
        <main class="p-4 sm:p-6 lg:p-8 flex-1">
            @yield('content')
        </main>

        <!-- Simple Dashboard Footer -->
        <footer class="px-4 sm:px-8 py-4 border-t border-slate-200 bg-white text-[11px] sm:text-xs text-slate-500 flex flex-col sm:flex-row items-center justify-between gap-2 shrink-0">
            <div>© {{ date('Y') }} شركة نبيكو العربية للتشغيل والصيانة. جميع الحقوق محفوظة.</div>
            <div class="flex gap-3">
                <span>كود البناء السعودي SBC 801</span>
                <span>•</span>
                <span>منصة سلامة</span>
            </div>
        </footer>

    </div>

    <!-- MOBILE BOTTOM APP BAR (Native App Feel for Field Staff) -->
    <nav class="lg:hidden fixed bottom-0 inset-x-0 bg-slate-900 border-t border-slate-800 flex items-center justify-around py-2 px-1 z-30 text-[10px] font-bold text-slate-400">
        <a href="{{ route('dashboard.home') }}" class="flex flex-col items-center gap-1 py-1 px-2 rounded-lg {{ request()->routeIs('dashboard.home') ? 'text-blue-400' : 'hover:text-white' }}">
            <span class="text-base">📊</span>
            <span>الرئيسية</span>
        </a>
        <a href="{{ route('dashboard.contracts') }}" class="flex flex-col items-center gap-1 py-1 px-2 rounded-lg {{ request()->routeIs('dashboard.contracts') ? 'text-blue-400' : 'hover:text-white' }}">
            <span class="text-base">🌲</span>
            <span>العقود</span>
        </a>
        <a href="{{ route('dashboard.visits') }}" class="flex flex-col items-center gap-1 py-1 px-2 rounded-lg {{ request()->routeIs('dashboard.visits') ? 'text-blue-400' : 'hover:text-white' }}">
            <span class="text-base">👷</span>
            <span>الزيارات</span>
        </a>
        <a href="{{ route('dashboard.reports') }}" class="flex flex-col items-center gap-1 py-1 px-2 rounded-lg {{ request()->routeIs('dashboard.reports') ? 'text-blue-400' : 'hover:text-white' }}">
            <span class="text-base">📝</span>
            <span>النماذج</span>
        </a>
        <a href="{{ route('dashboard.internal_requests') }}" class="flex flex-col items-center gap-1 py-1 px-2 rounded-lg {{ request()->routeIs('dashboard.internal_requests') ? 'text-blue-400' : 'hover:text-white' }}">
            <span class="text-base">🔄</span>
            <span>الطلبات</span>
        </a>
        <button onclick="toggleSidebar()" class="flex flex-col items-center gap-1 py-1 px-2 rounded-lg hover:text-white text-slate-300">
            <span class="text-base">☰</span>
            <span>المزيد</span>
        </button>
    </nav>

    <!-- JS for Mobile Drawer -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('mobile-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            
            const isOpen = sidebar.classList.contains('translate-x-0');
            if (isOpen) {
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('translate-x-full');
                backdrop.classList.add('hidden');
            } else {
                sidebar.classList.remove('translate-x-full');
                sidebar.classList.add('translate-x-0');
                backdrop.classList.remove('hidden');
            }
        }
    </script>

</body>
</html>
