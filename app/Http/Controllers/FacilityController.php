<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Facility;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FacilityController extends Controller
{
    public function index()
    {
        $user = session('user');
        $facilities = Facility::with(['clientUser', 'activeContract', 'visits'])->latest()->get();
        $clients = User::where('role', 'client')->get();

        return view('dashboard.facilities', compact('facilities', 'clients', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sector' => 'required|string',
            'city' => 'required|string',
            'zone_type' => 'required|in:inside_city,outside_city',
            'contact_person' => 'nullable|string',
            'contact_phone' => 'nullable|string',
            'safety_license_number' => 'nullable|string',
            'safety_license_expiry' => 'nullable|date',
        ]);

        $company = Company::first();

        Facility::create([
            'company_id' => $company->id,
            'client_user_id' => $request->client_user_id,
            'name' => $request->name,
            'sector' => $request->sector,
            'city' => $request->city,
            'district' => $request->district,
            'zone_type' => $request->zone_type,
            'address' => $request->address,
            'contact_person' => $request->contact_person,
            'contact_phone' => $request->contact_phone,
            'contact_email' => $request->contact_email,
            'safety_license_number' => $request->safety_license_number,
            'safety_license_expiry' => $request->safety_license_expiry ? Carbon::parse($request->safety_license_expiry) : null,
            'notes' => $request->notes,
        ]);

        return back()->with('success', 'تم تسجيل المنشأة / الموقع الجديد بنجاح');
    }
}
