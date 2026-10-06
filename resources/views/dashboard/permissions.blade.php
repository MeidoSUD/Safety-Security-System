@extends('layouts.dashboard')

@section('title', 'إدارة الصلاحيات والأدوار | نبيكو العربية ERP')
@section('page_title', 'إدارة الصلاحيات والأدوار ومصفوفة الأمان (Roles & Permissions Matrix)')

@section('content')

    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                <span>⚙️ مصفوفة الصلاحيات والتحكم بالأدوار (RBAC Management)</span>
                <span class="text-xs px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 font-semibold">أمان وتحكم كامل</span>
            </h2>
            <p class="text-xs text-slate-500 mt-0.5">
                تحديد وضبط الصلاحيات لكل دور وظيفي بالمنظومة (تعديل العقود، تخصيص نماذج الفحص، تسعير النطاق الجغرافي، اعتماد الطلبات).
            </p>
        </div>

        <button onclick="alert('تم حفظ مصفوفة الصلاحيات المحدثة بنجاح')" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-lg text-xs font-bold transition-colors">
            حفظ التغييرات للصلاحيات ✓
        </button>
    </div>

    <!-- Permissions Matrix Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-700 border-b border-slate-200 font-bold">
                        <th class="p-4">الدور الوظيفي</th>
                        <th class="p-4">الوصف ونطاق العمل</th>
                        <th class="p-4 text-center">إدارة العقود والمرفقات</th>
                        <th class="p-4 text-center">تخصيص نماذج الفحص</th>
                        <th class="p-4 text-center">تسعير الزيارات والنطاق</th>
                        <th class="p-4 text-center">الطلبات بين الإدارات</th>
                        <th class="p-4 text-center">التقارير المالية</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($rolesList as $role)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="p-4">
                                <b class="text-slate-900 block text-xs">{{ $role['name'] }}</b>
                                <span class="text-[10px] text-slate-400">عدد المستخدمين: {{ $role['users_count'] }}</span>
                            </td>
                            <td class="p-4 text-slate-600 max-w-xs leading-relaxed text-[11px]">
                                {{ $role['description'] }}
                            </td>
                            <td class="p-4 text-center">
                                <input type="checkbox" {{ $role['permissions']['manage_contracts'] ? 'checked' : '' }} class="rounded text-blue-600 focus:ring-0 cursor-pointer">
                            </td>
                            <td class="p-4 text-center">
                                <input type="checkbox" {{ $role['permissions']['manage_templates'] ? 'checked' : '' }} class="rounded text-blue-600 focus:ring-0 cursor-pointer">
                            </td>
                            <td class="p-4 text-center">
                                <input type="checkbox" {{ $role['permissions']['manage_pricing'] ? 'checked' : '' }} class="rounded text-blue-600 focus:ring-0 cursor-pointer">
                            </td>
                            <td class="p-4 text-center">
                                <input type="checkbox" {{ $role['permissions']['approve_requests'] ? 'checked' : '' }} class="rounded text-blue-600 focus:ring-0 cursor-pointer">
                            </td>
                            <td class="p-4 text-center">
                                <input type="checkbox" {{ $role['permissions']['view_financials'] ? 'checked' : '' }} class="rounded text-blue-600 focus:ring-0 cursor-pointer">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick User Management Box -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
        <h3 class="text-sm font-bold text-slate-900 mb-3">حسابات النظام النشطة</h3>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3 text-xs">
            <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 flex items-center justify-between">
                <div>
                    <b class="text-slate-900 block">م. عبدالرحمن المنصور</b>
                    <span class="text-slate-500 text-[11px]">admin@nabico.sa (Admin)</span>
                </div>
                <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 text-[10px] font-bold">نشط</span>
            </div>

            <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 flex items-center justify-between">
                <div>
                    <b class="text-slate-900 block">أ. طارق الشمري</b>
                    <span class="text-slate-500 text-[11px]">manager@nabico.sa (Operations)</span>
                </div>
                <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 text-[10px] font-bold">نشط</span>
            </div>

            <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 flex items-center justify-between">
                <div>
                    <b class="text-slate-900 block">سالم الدوسري</b>
                    <span class="text-slate-500 text-[11px]">supervisor@nabico.sa (Field)</span>
                </div>
                <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 text-[10px] font-bold">نشط</span>
            </div>
        </div>
    </div>

@endsection
