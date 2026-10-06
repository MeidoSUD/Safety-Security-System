<!DOCTYPE html>
<html lang="ar" dir="rtl" class="h-full bg-slate-50 text-slate-900">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>@yield('title', 'شركة نبيكو العربية للتشغيل والصيانة | حلول الأمن والسلامة')</title>
    <meta name="description" content="شركة متخصصة في حلول الأمن والسلامة، مكافحة الحريق، عقود الصيانة الدورية للمدارس والمصانع، وتراخيص الدفاع المدني ومنصة سلامة.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e293b',
                            900: '#0f172a',
                        },
                        safety: {
                            red: '#dc2626',
                            emerald: '#059669',
                            amber: '#d97706'
                        }
                    },
                    fontFamily: {
                        cairo: ['Cairo', 'sans-serif'],
                        sans: ['Cairo', 'sans-serif']
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
        .page-transition {
            animation: fadeIn 0.3s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="min-h-full flex flex-col bg-slate-50 text-slate-800 antialiased selection:bg-slate-900 selection:text-white">

    <!-- Simple Clean Top Bar -->
    <div class="bg-slate-900 text-slate-300 text-xs py-2 px-4 border-b border-slate-800">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-2">
            <div class="flex items-center gap-2 sm:gap-3">
                <span class="inline-flex items-center gap-1 text-emerald-400 font-semibold text-[11px] sm:text-xs">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    معتمد لدى الدفاع المدني ومنصة سلامة
                </span>
                <span class="text-slate-500 hidden sm:inline">•</span>
                <span class="text-slate-400 hidden sm:inline">كود البناء السعودي SBC 801</span>
            </div>
            <div class="flex items-center gap-3 text-xs">
                <span class="text-slate-300 text-[11px] sm:text-xs">طوارئ: <b class="text-white font-mono">9200-NABICO</b></span>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">
                
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 focus:outline-none shrink-0">
                    <img src="{{ asset('logo.png') }}" alt="شعار الشركة" class="h-10 sm:h-14 w-auto object-contain">
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-7 text-sm font-semibold text-slate-600">
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-slate-950 font-bold border-b-2 border-slate-900 pb-1' : 'hover:text-slate-950 transition-colors' }}">الرئيسية</a>
                    <a href="{{ route('services') }}" class="{{ request()->routeIs('services') ? 'text-slate-950 font-bold border-b-2 border-slate-900 pb-1' : 'hover:text-slate-950 transition-colors' }}">الخدمات</a>
                    <a href="{{ route('sectors') }}" class="{{ request()->routeIs('sectors') ? 'text-slate-950 font-bold border-b-2 border-slate-900 pb-1' : 'hover:text-slate-950 transition-colors' }}">القطاعات (المدارس والمصانع)</a>
                    <a href="{{ route('dashboard.home') }}" class="{{ request()->routeIs('dashboard*') ? 'text-blue-700 font-bold border-b-2 border-blue-700 pb-1' : 'text-blue-700 hover:text-blue-800 transition-colors flex items-center gap-1 font-bold' }}">
                        <span>⚡ لوحة تحكم ERP</span>
                    </a>
                    <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'text-slate-900 font-bold border-b-2 border-slate-900 pb-1' : 'hover:text-slate-950 transition-colors' }}">اتصل بنا</a>
                </nav>

                <!-- Actions / CTAs + Mobile Menu Trigger -->
                <div class="flex items-center gap-2 sm:gap-3">
                    <a href="{{ route('dashboard.home') }}" class="px-3 sm:px-4 py-2 rounded-lg text-xs sm:text-sm font-bold text-white bg-slate-900 hover:bg-slate-800 transition-colors shadow-sm flex items-center gap-1">
                        <span>دخول النظام</span>
                        <span>←</span>
                    </a>

                    <!-- Mobile Menu Button -->
                    <button onclick="togglePublicMobileMenu()" class="md:hidden p-2 rounded-lg bg-slate-100 text-slate-800 focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                </div>

            </div>

            <!-- Mobile Dropdown Menu -->
            <div id="public-mobile-menu" class="hidden md:hidden border-t border-slate-100 py-3 space-y-2 text-xs font-bold text-slate-700">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-100">الرئيسية</a>
                <a href="{{ route('services') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-100">الخدمات</a>
                <a href="{{ route('sectors') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-100">القطاعات (المدارس والمصانع)</a>
                <a href="{{ route('dashboard.home') }}" class="block px-3 py-2 rounded-lg bg-blue-50 text-blue-700 font-bold">⚡ لوحة تحكم ERP</a>
                <a href="{{ route('membership') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-100">طلب عضوية</a>
                <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-100">اتصل بنا</a>
            </div>
        </div>
    </header>

    <!-- Main Page Content -->
    <main class="flex-grow page-transition">
        @yield('content')
    </main>

    <!-- Clean Minimalist Footer -->
    <footer class="bg-white border-t border-slate-200 mt-12 sm:mt-20 text-slate-600 text-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 mb-8">
                
                <div class="space-y-3">
                    <img src="{{ asset('logo.png') }}" alt="شعار الشركة" class="h-10 w-auto object-contain">
                    <p class="text-xs text-slate-500 leading-relaxed">
                        حلول هندسة السلامة المعتمدة، أنظمة مكافحة الحريق، وعقود الصيانة السنوية للمنشآت التعليمية والصناعية في المملكة العربية السعودية.
                    </p>
                </div>

                <div>
                    <h4 class="font-bold text-slate-900 mb-3 text-xs uppercase tracking-wider">صفحات الموقع</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('services') }}" class="hover:text-slate-900">خدمات السلامة ومكافحة الحريق</a></li>
                        <li><a href="{{ route('sectors') }}" class="hover:text-slate-900">حلول المدارس والمصانع</a></li>
                        <li><a href="{{ route('dashboard.home') }}" class="hover:text-slate-900">منظومة ERP الميدانية</a></li>
                        <li><a href="{{ route('membership') }}" class="hover:text-slate-900">طلب فتح ملف منشأة</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-slate-900 mb-3 text-xs uppercase tracking-wider">فروعنا بالمملكة</h4>
                    <ul class="space-y-2 text-xs text-slate-500">
                        <li><b>الرياض:</b> طريق الملك فهد - حي العليا</li>
                        <li><b>جدة:</b> طريق المدينة المنورة</li>
                        <li><b>الدمام:</b> المنطقة الصناعية</li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-slate-900 mb-3 text-xs uppercase tracking-wider">التواصل والدعم</h4>
                    <div class="space-y-2 text-xs text-slate-500">
                        <div>الهاتف الموحد: <span class="font-bold font-mono text-slate-800">9200-NABICO</span></div>
                        <div>البريد: <span class="font-mono text-slate-800">info@nabico.sa</span></div>
                        <div class="pt-2">
                            <span class="inline-block px-2.5 py-1 bg-emerald-50 text-emerald-700 text-[11px] font-semibold rounded-md border border-emerald-200">
                                ترخيص سلامة: SLM-2026
                            </span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="border-t border-slate-100 pt-6 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-2">
                <div>© {{ date('Y') }} شركة نبيكو العربية للتشغيل والصيانة. جميع الحقوق محفوظة.</div>
                <div>مطابق لاشتراطات كود البناء السعودي والدفاع المدني.</div>
            </div>
        </div>
    </footer>

    <script>
        function togglePublicMobileMenu() {
            const menu = document.getElementById('public-mobile-menu');
            menu.classList.toggle('hidden');
        }
    </script>

</body>
</html>
