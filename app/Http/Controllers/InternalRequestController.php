<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\InternalRequest;
use App\Models\User;
use Illuminate\Http\Request;

class InternalRequestController extends Controller
{
    public function index()
    {
        $user = session('user');
        $company = Company::first();
        $internalRequests = InternalRequest::with(['requester', 'reviewer'])->latest()->get();

        return view('dashboard.internal_requests', compact('user', 'internalRequests', 'company'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_from' => 'required|string',
            'department_to' => 'required|string',
            'request_type' => 'required|string',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
        ]);

        $user = session('user');
        $company = Company::first();

        InternalRequest::create([
            'company_id' => $company->id,
            'requester_id' => $user['id'] ?? null,
            'department_from' => $request->department_from,
            'department_to' => $request->department_to,
            'request_type' => $request->request_type,
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => 'pending',
        ]);

        return back()->with('success', 'تم إرسال الطلب الداخلي إلى الإدارة المعنية بنجاح.');
    }

    public function updateStatus(Request $request, $id)
    {
        $internalRequest = InternalRequest::findOrFail($id);
        $user = session('user');

        $internalRequest->update([
            'status' => $request->status,
            'reviewed_by_id' => $user['id'] ?? null,
            'review_notes' => $request->review_notes ?? 'تمت المعالجة من قبل الإدارة',
        ]);

        return back()->with('success', 'تم تحديث حالة الطلب الداخلي بنجاح.');
    }
}
