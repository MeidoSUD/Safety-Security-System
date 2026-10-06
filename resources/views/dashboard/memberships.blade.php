@extends('layouts.dashboard')

@section('title', 'طلبات التسجيل الجديدة | نبيكو العربية ERP')
@section('page_title', 'طابور طلبات التسجيل وفتح الملفات (Onboarding Queue)')

@section('content')

    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-base font-bold text-slate-900">طلبات المدارس والمصانع الجديدة للانضمام والتعاقد</h2>
            <p class="text-xs text-slate-500 mt-0.5">مراجعة بيانات المنشأة واعتماد فتح ملف صيانة وربط ترخيص سلامة.</p>
        </div>
        <span class="px-3 py-1 bg-blue-50 text-blue-700 font-bold text-xs rounded-lg border border-blue-200">
            3 طلبات قيد الانتظار
        </span>
    </div>

    <!-- Requests List -->
    <div class="space-y-4">
        @foreach($requests as $req)
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="font-mono text-xs font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded">#{{ $req['id'] }}</span>
                        <h3 class="text-sm font-bold text-slate-900">{{ $req['facility'] }}</h3>
                        <span class="px-2 py-0.5 bg-blue-50 text-blue-700 text-[11px] font-bold rounded">{{ $req['type'] }}</span>
                        <span class="text-slate-400 text-xs">• {{ $req['created_at'] }}</span>
                    </div>

                    <div class="text-xs text-slate-600 flex flex-wrap gap-4">
                        <span>المدينة: <b>{{ $req['city'] }}</b></span>
                        <span>•</span>
                        <span>المسؤول: <b>{{ $req['contact'] }}</b></span>
                        <span>•</span>
                        <span>المساحة: <b class="font-mono text-slate-800">{{ $req['area'] }}</b></span>
                    </div>

                    <div class="text-xs text-slate-700 bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                        الخدمة المطلوبة: <b>{{ $req['service'] }}</b>
                    </div>
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    @if($req['status'] == 'pending')
                        <button onclick="approveRequest(this, '{{ $req['facility'] }}')" class="px-4 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-bold transition-colors">
                            اعتماد وفتح ملف فوراً ✓
                        </button>
                    @else
                        <span class="px-3 py-1.5 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-lg">
                            معتمد ساري ✓
                        </span>
                    @endif
                    <button onclick="alert('تفاصيل طلب منشأة: {{ $req['facility'] }}')" class="px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-800 rounded-xl text-xs font-bold transition-colors">
                        تفاصيل الطلب
                    </button>
                </div>

            </div>
        @endforeach
    </div>

    <script>
        function approveRequest(btn, name) {
            btn.parentElement.innerHTML = '<span class="px-3 py-1.5 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-lg">تم الاعتماد وفتح الملف بنجاح ✓</span>';
            alert('تم اعتماد منشأة: ' + name + ' وإدراجها بنجاح في شجرة العقود.');
        }
    </script>

@endsection
