@extends('layouts.dashboard')

@section('title', 'مركز التنبيهات والتذكيرات الآلية | نبيكو ERP')
@section('page_title', 'مركز الإشعارات والتنبيهات الميدانية والتذكيرات التلقائية')

@section('content')

    <!-- TOP HEADER -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <div class="flex items-center gap-2">
            <span class="text-xl">🔔</span>
            <div>
                <h2 class="text-sm font-bold text-slate-900">سجل الإشعارات والتذكيرات الميدانية</h2>
                <div class="text-[11px] text-slate-500">تذكير الزيارات بـ 48 ساعة • تنبيهات قطع الغيار غير المسددة • بلاغات الصيانة</div>
            </div>
        </div>

        <form action="{{ route('dashboard.notifications.read_all') }}" method="POST">
            @csrf
            <button type="submit" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition-colors">
                تعيين الكل كمقروء ✓
            </button>
        </form>
    </div>

    <!-- NOTIFICATIONS LIST -->
    <div class="space-y-3">
        @forelse($notifications as $notif)
            <div class="bg-white rounded-2xl border {{ !$notif->is_read ? ($notif->priority === 'warning' ? 'border-amber-300 bg-amber-50/40 ring-2 ring-amber-100' : 'border-blue-300 bg-blue-50/30') : 'border-slate-200' }} p-5 shadow-sm space-y-2 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                
                <div class="space-y-1">
                    <div class="flex items-center gap-2">
                        @if($notif->priority === 'warning')
                            <span class="text-lg">⚠️</span>
                        @elseif($notif->type === 'visit_reminder_48h')
                            <span class="text-lg">🔔</span>
                        @else
                            <span class="text-lg">📥</span>
                        @endif

                        <h3 class="text-xs sm:text-sm font-bold text-slate-900">{{ $notif->title }}</h3>
                        
                        @if(!$notif->is_read)
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-600 text-white font-mono">
                                جديد
                            </span>
                        @endif
                    </div>

                    <p class="text-xs text-slate-600 pr-7">{{ $notif->message }}</p>
                    <div class="text-[10px] text-slate-400 font-mono pr-7">{{ $notif->created_at->diffForHumans() }}</div>
                </div>

                <div class="shrink-0 flex items-center gap-2">
                    @if($notif->target_url)
                        <a href="{{ $notif->target_url }}" class="px-3.5 py-1.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition-colors">
                            معاينة 🔍
                        </a>
                    @endif

                    @if(!$notif->is_read)
                        <form action="{{ route('dashboard.notifications.read', $notif->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold">
                                تحديد كمقروء
                            </button>
                        </form>
                    @endif
                </div>

            </div>
        @empty
            <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center text-slate-400">
                لا توجد إشعارات أو تذكيرات حالياً.
            </div>
        @endforelse
    </div>

@endsection
