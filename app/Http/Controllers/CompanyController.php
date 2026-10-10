<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $user = session('user');
        $companies = Company::withCount(['users', 'facilities', 'contracts', 'visits'])->get();
        $currentCompany = Company::first();

        return view('dashboard.saas_settings', compact('companies', 'currentCompany', 'user'));
    }

    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'zone_rate_inside' => 'required|numeric|min:0',
            'zone_rate_outside' => 'required|numeric|min:0',
            'subscription_plan' => 'required|in:starter,pro,enterprise',
            'subscription_status' => 'required|in:active,trial,expired',
        ]);

        $company->update([
            'name' => $request->name,
            'cr_number' => $request->cr_number,
            'tax_number' => $request->tax_number,
            'phone' => $request->phone,
            'email' => $request->email,
            'city' => $request->city,
            'address' => $request->address,
            'zone_rate_inside' => $request->zone_rate_inside,
            'zone_rate_outside' => $request->zone_rate_outside,
            'subscription_plan' => $request->subscription_plan,
            'subscription_status' => $request->subscription_status,
            'sms_reminder_enabled' => $request->boolean('sms_reminder_enabled'),
        ]);

        return back()->with('success', 'تم حفظ إعدادات وتسعيرات الـ SaaS بنجاح');
    }
}
