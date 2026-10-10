<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Contract;
use App\Models\Facility;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ContractController extends Controller
{
    public function index()
    {
        $user = session('user');
        $role = $user['role'] ?? 'admin';
        $userId = $user['id'] ?? 1;

        $query = Contract::with(['facility.clientUser', 'visits']);

        if ($role === 'client') {
            $query->whereHas('facility', function($q) use ($userId) {
                $q->where('client_user_id', $userId)->orWhere('name', 'LIKE', '%الأندلس%');
            });
            $facilities = Facility::where('client_user_id', $userId)->orWhere('name', 'LIKE', '%الأندلس%')->get();
        } else {
            $facilities = Facility::all();
        }

        $contracts = $query->latest()->get();

        return view('dashboard.contracts', compact('contracts', 'facilities', 'user', 'role'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'facility_id' => 'required|exists:facilities,id',
            'title' => 'required|string|max:255',
            'contract_type' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'total_amount' => 'required|numeric|min:0',
            'visits_quota' => 'required|integer|min:1',
        ]);

        $company = Company::first();
        $cntNumber = 'CNT-' . date('Y') . '-' . rand(100, 999);

        Contract::create([
            'company_id' => $company->id,
            'facility_id' => $request->facility_id,
            'contract_number' => $cntNumber,
            'title' => $request->title,
            'contract_type' => $request->contract_type,
            'start_date' => Carbon::parse($request->start_date),
            'end_date' => Carbon::parse($request->end_date),
            'total_amount' => $request->total_amount,
            'visits_quota' => $request->visits_quota,
            'visits_used' => 0,
            'status' => 'active',
            'notes' => $request->notes,
        ]);

        return back()->with('success', "تم إنشاء العقد السنوي بنجاح برقم #{$cntNumber}");
    }
}
