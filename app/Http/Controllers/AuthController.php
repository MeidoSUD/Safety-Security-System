<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        $demoUsers = User::with('company')->get();
        return view('pages.login', compact('demoUsers'));
    }

    public function login(Request $request)
    {
        $role = $request->input('role');
        $email = $request->input('email');
        $password = $request->input('password');

        // Quick demo login by role button
        if ($role) {
            $user = User::where('role', $role)->first();
            if (!$user) {
                $user = User::first();
            }
        } elseif ($email) {
            // Standard credentials login
            $user = User::where('email', $email)->first();
            if (!$user || !Hash::check($password, $user->password)) {
                // If demo password or fallback
                if ($password !== 'password' && (!$user || !Hash::check($password, $user->password))) {
                    return back()->with('error', 'بيانات تسجيل الدخول غير صحيحة')->withInput();
                }
            }
        } else {
            $user = User::where('role', 'admin')->first() ?? User::first();
        }

        if ($user) {
            Auth::login($user);
            session([
                'authenticated' => true,
                'user' => [
                    'id' => $user->id,
                    'company_id' => $user->company_id,
                    'role' => $user->role,
                    'name' => $user->name,
                    'title' => $user->job_title ?? $user->role_arabic_title,
                    'avatar' => $user->avatar_emoji ?? '👤',
                    'email' => $user->email,
                ],
                'user_role' => $user->role,
                'company_id' => $user->company_id,
            ]);

            return redirect()->route('dashboard.home')->with('success', 'مرحباً بك: ' . $user->name . ' (' . ($user->job_title ?? $user->role_arabic_title) . ')');
        }

        return redirect()->route('login')->with('error', 'لم يتم العثور على الحساب');
    }

    public function switchRole(Request $request)
    {
        $role = $request->input('role', 'admin');
        $user = User::where('role', $role)->first();

        if ($user) {
            Auth::login($user);
            session([
                'authenticated' => true,
                'user' => [
                    'id' => $user->id,
                    'company_id' => $user->company_id,
                    'role' => $user->role,
                    'name' => $user->name,
                    'title' => $user->job_title ?? $user->role_arabic_title,
                    'avatar' => $user->avatar_emoji ?? '👤',
                    'email' => $user->email,
                ],
                'user_role' => $user->role,
                'company_id' => $user->company_id,
            ]);

            return back()->with('success', 'تم تبديل حساب العرض إلى: ' . ($user->job_title ?? $user->name));
        }

        return back()->with('error', 'الدور المطلوب غير متوفر');
    }

    public function logout()
    {
        Auth::logout();
        session()->forget(['authenticated', 'user', 'user_role', 'company_id']);
        return redirect()->route('login')->with('info', 'تم تسجيل الخروج بنجاح');
    }
}
