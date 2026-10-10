<!DOCTYPE html>
<html lang="ar" dir="rtl" class="h-full bg-slate-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تسجيل الدخول | شركة نبيكو العربية للتشغيل والصيانة</title>

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
                            rose: '#e11d48'
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
    </style>
</head>
<body class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-slate-100 text-slate-900 selection:bg-slate-900 selection:text-white">

    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center space-y-3">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="inline-block">
            <img src="{{ asset('logo.png') }}" alt="شركة نبيكو العربية" class="h-16 w-auto mx-auto object-contain">
        </a>
        <h1 class="text-2xl font-extrabold text-slate-900">بوابة الدخول للنظام الميداني ERP</h1>
        <p class="text-xs text-slate-500">شركة نبيكو العربية للتشغيل والصيانة • معتمد من منصة سلامة 🇸🇦</p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-xl">
        <div class="bg-white py-8 px-6 shadow-sm sm:rounded-2xl sm:px-10 border border-slate-200 space-y-6">
            
            <!-- Quick Role Select Cards (Demo Mode - Core User Request) -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-2">
                    ⚡ اختر الدور لتسجيل الدخول الفوري وتجربة النظام:
                </label>
                
                <div class="grid sm:grid-cols-2 gap-2 text-xs">
                    
                    <!-- Role 1: Admin -->
                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf
                        <input type="hidden" name="role" value="admin">
                        <button type="submit" class="w-full text-right p-3 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 hover:border-slate-400 transition-all flex items-center justify-between group">
                            <div class="flex items-center gap-2.5">
                                <span class="text-xl">👑</span>
                                <div>
                                    <b class="text-slate-900 block group-hover:text-blue-700">الأدمن / الإدارة العليا</b>
                                    <span class="text-[11px] text-slate-500">صلاحيات كاملة ولوحة التقارير</span>
                                </div>
                            </div>
                            <span class="text-slate-400 font-bold group-hover:translate-x-[-2px] transition-transform">←</span>
                        </button>
                    </form>

                    <!-- Role 2: Operations Manager -->
                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf
                        <input type="hidden" name="role" value="manager">
                        <button type="submit" class="w-full text-right p-3 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 hover:border-slate-400 transition-all flex items-center justify-between group">
                            <div class="flex items-center gap-2.5">
                                <span class="text-xl">🏢</span>
                                <div>
                                    <b class="text-slate-900 block group-hover:text-blue-700">مدير العمليات والعقود</b>
                                    <span class="text-[11px] text-slate-500">شجرة العقود والزيارات</span>
                                </div>
                            </div>
                            <span class="text-slate-400 font-bold group-hover:translate-x-[-2px] transition-transform">←</span>
                        </button>
                    </form>

                    <!-- Role 3: Supervisor -->
                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf
                        <input type="hidden" name="role" value="supervisor">
                        <button type="submit" class="w-full text-right p-3 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 hover:border-slate-400 transition-all flex items-center justify-between group">
                            <div class="flex items-center gap-2.5">
                                <span class="text-xl">🛡️</span>
                                <div>
                                    <b class="text-slate-900 block group-hover:text-blue-700">مشرف الميدان والفنيين</b>
                                    <span class="text-[11px] text-slate-500">مسح QR وتوثيق الفحص</span>
                                </div>
                            </div>
                            <span class="text-slate-400 font-bold group-hover:translate-x-[-2px] transition-transform">←</span>
                        </button>
                    </form>

                    <!-- Role 4: Field Technician -->
                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf
                        <input type="hidden" name="role" value="technician">
                        <button type="submit" class="w-full text-right p-3 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 hover:border-slate-400 transition-all flex items-center justify-between group">
                            <div class="flex items-center gap-2.5">
                                <span class="text-xl">👷</span>
                                <div>
                                    <b class="text-slate-900 block group-hover:text-blue-700">الفني / التقني</b>
                                    <span class="text-[11px] text-slate-500">فحص المضخات واستمارات PSI</span>
                                </div>
                            </div>
                            <span class="text-slate-400 font-bold group-hover:translate-x-[-2px] transition-transform">←</span>
                        </button>
                    </form>

                    <!-- Role 5: Client (School / Factory) -->
                    <form action="{{ route('login.post') }}" method="POST" class="sm:col-span-2">
                        @csrf
                        <input type="hidden" name="role" value="client">
                        <button type="submit" class="w-full text-right p-3 rounded-xl border border-blue-200 bg-blue-50/50 hover:bg-blue-100/50 transition-all flex items-center justify-between group">
                            <div class="flex items-center gap-2.5">
                                <span class="text-xl">🏫</span>
                                <div>
                                    <b class="text-blue-950 block">بوابة العميل (مدارس الأندلس الأهلية / مصنع الخزف)</b>
                                    <span class="text-[11px] text-blue-700">استعراض شهادات الدفاع المدني وعقد الصيانة</span>
                                </div>
                            </div>
                            <span class="text-blue-700 font-bold group-hover:translate-x-[-2px] transition-transform">دخول ←</span>
                        </button>
                    </form>

                </div>
            </div>

            <!-- Divider -->
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-slate-200"></div>
                </div>
                <div class="relative flex justify-center text-xs">
                    <span class="px-3 bg-white text-slate-400 font-medium">أو تسجيل الدخول اليدوي</span>
                </div>
            </div>

            <!-- Standard Credentials Form -->
            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">البريد الإلكتروني أو اسم المستخدم</label>
                    <input type="text" name="email" required value="admin@nabico.sa" dir="ltr" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3.5 py-2.5 text-xs text-slate-900 focus:outline-none focus:border-slate-900 focus:bg-white text-right font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">كلمة المرور</label>
                    <input type="password" name="password" required value="password" dir="ltr" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3.5 py-2.5 text-xs text-slate-900 focus:outline-none focus:border-slate-900 focus:bg-white text-right font-mono">
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center gap-2 text-slate-600 cursor-pointer">
                        <input type="checkbox" checked class="rounded text-slate-900">
                        <span>تذكرني على هذا الجهاز</span>
                    </label>
                    <a href="#" class="text-slate-500 hover:text-slate-900">نسيت كلمة المرور؟</a>
                </div>

                <button type="submit" class="w-full py-3 bg-slate-900 hover:bg-slate-800 text-white rounded-lg font-bold text-xs shadow-sm transition-colors flex items-center justify-center gap-2">
                    <span>دخول لوحة التحكم الميدانية</span>
                    <span>←</span>
                </button>
            </form>

            <div class="text-center text-xs text-slate-500 border-t border-slate-100 pt-4">
                منشأة جديدة ترغب بالانضمام؟ 
                <a href="{{ route('membership') }}" class="font-bold text-slate-900 hover:underline">
                    طلب فتح ملف وعقد صيانة الآن
                </a>
            </div>

        </div>
    </div>

</body>
</html>
