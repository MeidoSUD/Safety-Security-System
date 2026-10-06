@extends('layouts.dashboard')

@section('title', 'سجل الأجهزة ومسح QR | نبيكو العربية ERP')
@section('page_title', 'سجل معدات السلامة ومسح باركود QR Code')

@section('content')

    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-base font-bold text-slate-900">سجل الأجهزة والمعدات المفحوصة عبر QR Code</h2>
            <p class="text-xs text-slate-500 mt-0.5">تتبع أجهزة الإطفاء ومضخات الحريق في جميع منشآت العملاء.</p>
        </div>
        <button onclick="alert('تم تفعيل كاميرا مسح الباركود')" class="px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white rounded-lg text-xs font-bold transition-colors flex items-center gap-1.5">
            <span>📷</span>
            <span>مسح كود QR جديد</span>
        </button>
    </div>

    <!-- Assets Grid -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach($assets as $a)
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-3">
                <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                    <span class="font-mono text-xs font-bold text-slate-700 bg-slate-100 px-2 py-0.5 rounded">{{ $a['code'] }}</span>
                    <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-emerald-100 text-emerald-800">{{ $a['status'] }}</span>
                </div>
                <div>
                    <h3 class="text-xs font-bold text-slate-900">{{ $a['name'] }}</h3>
                    <div class="text-[11px] text-blue-700 mt-0.5 font-semibold">{{ $a['facility'] }}</div>
                </div>
                <div class="text-[11px] text-slate-500 bg-slate-50 p-2.5 rounded-lg border border-slate-100 space-y-1">
                    <div>الموقع: <b>{{ $a['location'] }}</b></div>
                    <div>الفاحص: <b>{{ $a['inspector'] }}</b></div>
                    <div>تاريخ الفحص: <b class="font-mono text-slate-700">{{ $a['last_inspection'] }}</b></div>
                </div>
            </div>
        @endforeach
    </div>

@endsection
