<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('pages.login');
    }

    public function login(Request $request)
    {
        $role = $request->input('role', 'admin');
        
        $rolesData = [
            'admin' => [
                'role' => 'admin',
                'name' => 'م. عبدالرحمن المنصور',
                'title' => 'المدير التنفيذي (Admin)',
                'avatar' => '👑',
                'email' => 'admin@nabico.sa',
            ],
            'manager' => [
                'role' => 'manager',
                'name' => 'أ. طارق الشمري',
                'title' => 'مدير العمليات والعقود',
                'avatar' => '🏢',
                'email' => 'manager@nabico.sa',
            ],
            'supervisor' => [
                'role' => 'supervisor',
                'name' => 'سالم الدوسري',
                'title' => 'مشرف الميدان والفنيين',
                'avatar' => '🛡️',
                'email' => 'supervisor@nabico.sa',
            ],
            'technician' => [
                'role' => 'technician',
                'name' => 'فني أحمد القحطاني',
                'title' => 'فني صيانة شبكات ومضخات',
                'avatar' => '👷',
                'email' => 'tech@nabico.sa',
            ],
            'client' => [
                'role' => 'client',
                'name' => 'مدارس الأندلس الأهلية',
                'title' => 'حساب العميل (مدرسة/مصنع)',
                'avatar' => '🏫',
                'email' => 'client@andalus-school.sa',
            ],
        ];

        $user = $rolesData[$role] ?? $rolesData['admin'];

        session([
            'authenticated' => true,
            'user' => $user,
            'user_role' => $user['role']
        ]);

        return redirect()->route('dashboard.home')->with('success', 'مرحباً بك، تم تسجيل الدخول بنجاح');
    }

    public function switchRole(Request $request)
    {
        $role = $request->input('role', 'admin');
        
        $rolesData = [
            'admin' => [
                'role' => 'admin',
                'name' => 'م. عبدالرحمن المنصور',
                'title' => 'المدير التنفيذي (Admin)',
                'avatar' => '👑',
                'email' => 'admin@nabico.sa',
            ],
            'manager' => [
                'role' => 'manager',
                'name' => 'أ. طارق الشمري',
                'title' => 'مدير العمليات والعقود',
                'avatar' => '🏢',
                'email' => 'manager@nabico.sa',
            ],
            'supervisor' => [
                'role' => 'supervisor',
                'name' => 'سالم الدوسري',
                'title' => 'مشرف الميدان والفنيين',
                'avatar' => '🛡️',
                'email' => 'supervisor@nabico.sa',
            ],
            'technician' => [
                'role' => 'technician',
                'name' => 'فني أحمد القحطاني',
                'title' => 'فني صيانة شبكات ومضخات',
                'avatar' => '👷',
                'email' => 'tech@nabico.sa',
            ],
            'client' => [
                'role' => 'client',
                'name' => 'مدارس الأندلس الأهلية',
                'title' => 'حساب العميل (مدرسة/مصنع)',
                'avatar' => '🏫',
                'email' => 'client@andalus-school.sa',
            ],
        ];

        $user = $rolesData[$role] ?? $rolesData['admin'];

        session([
            'authenticated' => true,
            'user' => $user,
            'user_role' => $user['role']
        ]);

        return back()->with('success', 'تم تبديل الدور إلى: ' . $user['title']);
    }

    public function logout()
    {
        session()->forget(['authenticated', 'user', 'user_role']);
        return redirect()->route('login')->with('info', 'تم تسجيل الخروج بنجاح');
    }
}
