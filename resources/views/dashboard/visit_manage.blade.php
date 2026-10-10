@extends('layouts.dashboard')

@section('title', 'إدارة وتنفيذ الزيارة الميدانية #' . $visit->visit_number . ' | ERP')
@section('page_title', 'تنفيذ الزيارة الميدانية، توثيق صور الموقع، وإدارة قطع الغيار')

@section('content')

    <!-- TOP VISIT HEADER & STATUS BANNER -->
    <div class="bg-white rounded-3xl border {{ $visit->has_unpaid_parts ? 'border-amber-300 ring-4 ring-amber-100' : 'border-slate-200' }} p-6 sm:p-8 shadow-sm mb-6 space-y-6">
        
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 border-b border-slate-100 pb-6">
            <div class="space-y-1">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="font-mono text-sm font-black bg-slate-900 text-white px-2.5 py-1 rounded-lg">#{{ $visit->visit_number }}</span>
                    <h2 class="text-lg sm:text-xl font-black text-slate-900">{{ $visit->facility->name }}</h2>
                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">{{ $visit->type_arabic }}</span>
                    
                    @if($visit->status === 'in_progress')
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-900 border border-amber-300 animate-pulse">
                            قيد التنفيذ الميداني الآن ⚡
                        </span>
                    @elseif($visit->status === 'scheduled')
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-900 border border-blue-300">
                            مجدولة
                        </span>
                    @else
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-900 border border-emerald-300">
                            مكتملة ومغلقة ✓
                        </span>
                    @endif
                </div>

                <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500 pt-1">
                    <span>المدينة والقطاع: <b>{{ $visit->facility->city }} ({{ $visit->facility->sector_arabic }})</b></span>
                    <span>•</span>
                    <span>النطاق: <b>{{ $visit->location_zone === 'inside_city' ? 'داخل المدينة (350 ر.س)' : 'خارج المدينة (650 ر.س)' }}</b></span>
                    <span>•</span>
                    <span>الموعد المجدول: <b class="font-mono text-slate-800">{{ $visit->scheduled_at->format('Y-m-d h:i A') }}</b></span>
                </div>
            </div>

            <!-- Status Changer Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                <form action="{{ route('dashboard.visits.update_status', $visit->id) }}" method="POST" class="inline">
                    @csrf
                    @if($visit->status === 'scheduled')
                        <input type="hidden" name="status" value="in_progress">
                        <button type="submit" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold shadow transition-colors flex items-center gap-1.5">
                            <span>▶</span>
                            <span>بدء التنفيذ في الموقع (In Progress)</span>
                        </button>
                    @elseif($visit->status === 'in_progress')
                        <input type="hidden" name="status" value="completed">
                        <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow transition-colors flex items-center gap-1.5">
                            <span>✓</span>
                            <span>إنهاء وإغلاق الزيارة (Complete)</span>
                        </button>
                    @endif
                </form>

                <a href="{{ route('dashboard.visits') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold">
                    ← العودة للجدول
                </a>
            </div>
        </div>

        <!-- UNPAID PARTS ALERT IF PRESENT -->
        @if($visit->has_unpaid_parts)
            <div class="p-4 rounded-2xl bg-amber-500/10 border-2 border-amber-400 text-amber-950 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <span class="text-3xl">⚠️</span>
                    <div>
                        <b class="text-xs sm:text-sm block font-black">
                            تنبيه تحصيل: تم تسجيل قطع غيار غير مسددة على هذه الزيارة بقيمة {{ number_format($visit->unpaid_parts_amount, 2) }} ر.س!
                        </b>
                        <p class="text-[11px] text-amber-900 mt-0.5">
                            {{ $visit->unpaid_parts_notes }}
                        </p>
                    </div>
                </div>
                <button onclick="document.getElementById('add-item-modal').showModal()" class="px-3.5 py-1.5 bg-amber-800 text-white rounded-lg text-xs font-bold shrink-0">
                    تعديل / سداد البنود
                </button>
            </div>
        @endif

        <!-- Quick Facility & Engineer Meta Grid -->
        <div class="grid sm:grid-cols-3 gap-4 text-xs">
            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 space-y-1">
                <span class="text-slate-400 font-bold block text-[10px]">المهندس الفاحص المسؤول:</span>
                <b class="text-slate-900 text-xs">{{ $visit->engineer->name ?? 'لم يتم التعيين' }}</b>
                <div class="text-[11px] text-slate-500">{{ $visit->engineer->job_title ?? '' }}</div>
            </div>

            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 space-y-1">
                <span class="text-slate-400 font-bold block text-[10px]">مسؤول الموقع والاتصال:</span>
                <b class="text-slate-900 text-xs">{{ $visit->facility->contact_person ?? 'مدير الموقع' }}</b>
                <div class="text-[11px] font-mono text-slate-600">{{ $visit->facility->contact_phone ?? '0500000000' }}</div>
            </div>

            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 space-y-1">
                <span class="text-slate-400 font-bold block text-[10px]">حالة التعاقد ورسوم المعاينة:</span>
                <b class="text-slate-900 text-xs">{{ $visit->contract ? 'متعاقد (' . $visit->contract->contract_number . ')' : 'غير متعاقد' }}</b>
                <div class="text-[11px] text-slate-600 font-mono">{{ $visit->visit_fee > 0 ? number_format($visit->visit_fee, 2) . ' ر.س' : 'مغطى بالعقد السنوي' }}</div>
            </div>
        </div>

    </div>

    <!-- MAIN TWO-COLUMN WORKFLOW GRID (Left: Site Photos & Spare Parts | Right: Safety Checklist & Report) -->
    <div class="grid lg:grid-cols-12 gap-6">
        
        <!-- LEFT 7 COLS: SITE PHOTOS + MAINTENANCE ITEMS & SPARE PARTS -->
        <div class="lg:col-span-7 space-y-6">
            
            <!-- 1. SITE PHOTOS UPLOAD & GALLERY (Requirement) -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div class="flex items-center gap-2">
                        <span class="text-xl">📷</span>
                        <h3 class="text-sm font-bold text-slate-900">توثيق صور الموقع والأعطال الميدانية</h3>
                    </div>
                    <button onclick="document.getElementById('upload-image-modal').showModal()" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow transition-colors flex items-center gap-1.5">
                        <span>➕</span>
                        <span>إرفاق صورة جديدة</span>
                    </button>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    @forelse($visit->images as $img)
                        <div class="rounded-2xl border border-slate-200 overflow-hidden bg-slate-50 group hover:border-blue-300 transition-all shadow-sm">
                            <div class="h-40 bg-slate-200 relative overflow-hidden">
                                <img src="{{ $img->image_path }}" alt="{{ $img->caption }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <span class="absolute top-2 right-2 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-900/80 text-white backdrop-blur-sm">
                                    {{ $img->stage_arabic }}
                                </span>
                            </div>
                            <div class="p-3 text-xs space-y-1">
                                <b class="text-slate-900 block truncate">{{ $img->caption }}</b>
                                <div class="text-[10px] text-slate-400 font-mono">{{ $img->created_at->format('Y-m-d H:i') }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="sm:col-span-2 text-center py-8 text-xs text-slate-400 border border-dashed border-slate-300 rounded-2xl p-4">
                            <span class="text-3xl block mb-1">📷</span>
                            <span>لم يتم رفع صور لهذا الموقع بعد. انقر على "إرفاق صورة جديدة" لتوثيق الفحص.</span>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- 2. SPARE PARTS & MAINTENANCE ITEMS (Requirement: Add items, Unpaid flags) -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div class="flex items-center gap-2">
                        <span class="text-xl">🔩</span>
                        <h3 class="text-sm font-bold text-slate-900">قطع الغيار وبنود الصيانة المسجلة في الزيارة</h3>
                    </div>
                    <button onclick="document.getElementById('add-item-modal').showModal()" class="px-3 py-1.5 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold shadow transition-colors flex items-center gap-1.5">
                        <span>➕</span>
                        <span>إضافة قطعة غيار / بند</span>
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-right text-xs">
                        <thead class="bg-slate-50 text-slate-500 font-bold border-b border-slate-200">
                            <tr>
                                <th class="p-3">البند / القطعة</th>
                                <th class="p-3">الكمية</th>
                                <th class="p-3">السعر</th>
                                <th class="p-3">الحالة الفنية</th>
                                <th class="p-3">حالة السداد</th>
                                <th class="p-3">إجراء</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($visit->items as $item)
                                <tr class="hover:bg-slate-50/70">
                                    <td class="p-3 font-bold text-slate-900">
                                        {{ $item->item_name }}
                                        <span class="block text-[10px] text-slate-400">{{ $item->category_arabic }}</span>
                                    </td>
                                    <td class="p-3 font-mono font-bold">{{ $item->quantity }}</td>
                                    <td class="p-3 font-mono font-bold text-slate-900">{{ number_format($item->total_price, 2) }} ر.س</td>
                                    <td class="p-3">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-800">
                                            {{ $item->condition_arabic }}
                                        </span>
                                    </td>
                                    <td class="p-3">
                                        @if($item->payment_status === 'unpaid')
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-800 border border-red-200 animate-pulse">
                                                ⚠️ غير مسددة
                                            </span>
                                        @elseif($item->payment_status === 'paid')
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                                ✓ مسددة
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800">
                                                مغطاة بالعقد
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-3">
                                        <form action="{{ route('dashboard.visits.delete_item', [$visit->id, $item->id]) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا البند؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-sm">🗑️</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-6 text-center text-slate-400">
                                        لم يتم تسجيل أي قطع غيار أو بنود صيانة إضافية لهذه الزيارة حتى الآن.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- RIGHT 5 COLS: SAFETY INSPECTION CHECKLIST & REPORT GENERATION -->
        <div class="lg:col-span-5 space-y-6">
            
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div class="flex items-center gap-2">
                        <span class="text-xl">📝</span>
                        <h3 class="text-sm font-bold text-slate-900">تقرير الفحص الفني والاعتماد</h3>
                    </div>
                    @if($visit->report)
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                            تم إصدار التقرير ✓
                        </span>
                    @endif
                </div>

                @if($visit->report)
                    <!-- Report Details Display -->
                    <div class="p-4 rounded-2xl bg-emerald-50/60 border border-emerald-200 space-y-3 text-xs">
                        <div class="flex items-center justify-between">
                            <b class="text-emerald-950 font-bold">رقم التقرير: #{{ $visit->report->report_number }}</b>
                            <span class="px-2 py-0.5 rounded bg-emerald-200 text-emerald-900 font-bold text-[10px]">{{ $visit->report->status }}</span>
                        </div>
                        <div class="text-slate-700">
                            <b>النتيجة الإجمالية:</b>
                            <span class="font-bold text-slate-900">{{ $visit->report->overall_status_arabic }}</span>
                        </div>
                        <p class="text-slate-600 text-[11px] leading-relaxed">
                            {{ $visit->report->summary }}
                        </p>
                        <a href="{{ route('dashboard.reports.show', $visit->report->id) }}" class="block w-full text-center py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl font-bold text-xs shadow transition-colors">
                            عرض وطباعة شهادة الفحص الرسمية 📄
                        </a>
                    </div>
                @else
                    <!-- Report Generation Form -->
                    <form action="{{ route('dashboard.reports.store') }}" method="POST" class="space-y-4 text-xs">
                        @csrf
                        <input type="hidden" name="visit_id" value="{{ $visit->id }}">

                        <div>
                            <label class="block font-bold text-slate-700 mb-1">النتيجة الإجمالية للفحص <span class="text-red-500">*</span></label>
                            <select name="overall_status" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800">
                                <option value="passed">مطابق لمعايير السلامة والدفاع المدني (ناجح ✓)</option>
                                <option value="passed_with_notes">مطابق مع وجود ملاحظات تشغيلية واستبدال قطع</option>
                                <option value="critical_action_required">يتطلب إجراء عاجل وفوري ⚠️</option>
                                <option value="failed">غير مطابق - راسب</option>
                            </select>
                        </div>

                        <!-- Safety Systems Checklist -->
                        <div class="space-y-2 pt-2 border-t border-slate-100">
                            <b class="text-slate-800 block text-xs font-bold">قائمة التحقق الميداني (Inspection Checklist):</b>
                            
                            <div class="space-y-1.5 bg-slate-50 p-3 rounded-xl border border-slate-200 text-[11px]">
                                <label class="flex items-center justify-between cursor-pointer">
                                    <span>🚒 مضخات الحريق والضغط (Diesel & Electric):</span>
                                    <select name="check_fire_pumps" class="bg-white border border-slate-300 rounded px-2 py-0.5 font-bold">
                                        <option value="pass">سليم (Pass)</option>
                                        <option value="warning">ملاحظة</option>
                                        <option value="fail">عطل</option>
                                    </select>
                                </label>

                                <label class="flex items-center justify-between cursor-pointer">
                                    <span>🚨 لوحة وشبكة الإنذار المعنونة (Fire Alarm):</span>
                                    <select name="check_fire_alarm" class="bg-white border border-slate-300 rounded px-2 py-0.5 font-bold">
                                        <option value="pass">سليم (Pass)</option>
                                        <option value="warning">ملاحظة</option>
                                        <option value="fail">عطل</option>
                                    </select>
                                </label>

                                <label class="flex items-center justify-between cursor-pointer">
                                    <span>💦 شبكة الرش الآلي والمحابس (Sprinklers):</span>
                                    <select name="check_sprinklers" class="bg-white border border-slate-300 rounded px-2 py-0.5 font-bold">
                                        <option value="pass">سليم (Pass)</option>
                                        <option value="warning">ملاحظة</option>
                                        <option value="fail">عطل</option>
                                    </select>
                                </label>

                                <label class="flex items-center justify-between cursor-pointer">
                                    <span>🧯 طفايات الحريق اليدوية وصناديق الخراطيم:</span>
                                    <select name="check_extinguishers" class="bg-white border border-slate-300 rounded px-2 py-0.5 font-bold">
                                        <option value="pass">سليم (Pass)</option>
                                        <option value="warning">ملاحظة</option>
                                        <option value="fail">عطل</option>
                                    </select>
                                </label>
                            </div>
                        </div>

                        <!-- Summary & Recommendations -->
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">الملخص الهندسي للفحص <span class="text-red-500">*</span></label>
                            <textarea name="summary" rows="3" required placeholder="ملخص ما تم فحصه في الموقع..." class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800"></textarea>
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 mb-1">التوصيات والإجراءات المطلوبة</label>
                            <textarea name="recommendations" rows="2" placeholder="توصيات للمنشأة لضمان الامتثال التام..." class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800"></textarea>
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 mb-1">اسم ممثل المنشأة المستلم للتقرير</label>
                            <input type="text" name="client_signature_name" value="{{ $visit->facility->contact_person }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800">
                        </div>

                        <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-lg shadow-blue-500/20 transition-all">
                            اعتماد وحفظ تقرير الفحص الفني 📄
                        </button>
                    </form>
                @endif
            </div>

        </div>

    </div>

    <!-- MODAL 1: UPLOAD SITE PHOTO -->
    <dialog id="upload-image-modal" class="rounded-3xl border border-slate-200 p-0 shadow-2xl w-full max-w-lg bg-white backdrop:bg-slate-900/60">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50 rounded-t-3xl">
            <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                <span>📷</span>
                <span>إرفاق وتوثيق صورة الموقع</span>
            </h3>
            <button onclick="document.getElementById('upload-image-modal').close()" class="text-slate-400 hover:text-slate-700">✕</button>
        </div>

        <form action="{{ route('dashboard.visits.upload_image', $visit->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 text-xs">
            @csrf
            <div>
                <label class="block font-bold text-slate-700 mb-1">مرحلة التوثيق <span class="text-red-500">*</span></label>
                <select name="stage" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800">
                    <option value="defect_evidence">توثيق عطل / ملاحظة فنية (Defect Evidence)</option>
                    <option value="during_inspection">أثناء الفحص الميداني (During Inspection)</option>
                    <option value="before_work">قبل بدء الصيانة (Before Work)</option>
                    <option value="after_work">بعد إنجاز العمل والاستبدال (After Work)</option>
                </select>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">عنوان / وصف الصورة</label>
                <input type="text" name="caption" required placeholder="مثال: صورة فحص محبس مضخة الديزل وعداد الضغط" class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">رفع ملف صورة من الجهاز</label>
                <input type="file" name="image_file" accept="image/*" class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2 text-xs">
            </div>

            <div class="text-center text-[11px] text-slate-400 font-bold">— أو رابط صورة مباشر (URL) —</div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">رابط الصورة (Image URL)</label>
                <input type="url" name="image_url" placeholder="https://..." class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-mono">
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="document.getElementById('upload-image-modal').close()" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl font-bold">إلغاء</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-xl font-bold">حفظ الصورة ✓</button>
            </div>
        </form>
    </dialog>

    <!-- MODAL 2: ADD SPARE PART / ITEM -->
    <dialog id="add-item-modal" class="rounded-3xl border border-slate-200 p-0 shadow-2xl w-full max-w-lg bg-white backdrop:bg-slate-900/60">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50 rounded-t-3xl">
            <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                <span>🔩</span>
                <span>إضافة بند صيانة / قطعة غيار</span>
            </h3>
            <button onclick="document.getElementById('add-item-modal').close()" class="text-slate-400 hover:text-slate-700">✕</button>
        </div>

        <form action="{{ route('dashboard.visits.add_item', $visit->id) }}" method="POST" class="p-6 space-y-4 text-xs">
            @csrf

            <div>
                <label class="block font-bold text-slate-700 mb-1">اسم البند / قطعة الغيار <span class="text-red-500">*</span></label>
                <input type="text" name="item_name" required placeholder="مثال: محبس عدم رجوع 4 إنش UL/FM أو كاشف دخان ضوئي" class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">التصنيف</label>
                    <select name="item_category" class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800">
                        <option value="pump_part">مضخات حريق</option>
                        <option value="alarm_part">شبكة إنذار ولوحات</option>
                        <option value="sprinkler_part">رشاشات ومحابس</option>
                        <option value="extinguisher">طفايات حريق</option>
                        <option value="general_spare">قطع غيار عامة</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">الكمية <span class="text-red-500">*</span></label>
                    <input type="number" name="quantity" min="1" value="1" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold font-mono">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">سعر الوحدة (ر.س) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="unit_price" value="0.00" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold font-mono">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">الحالة الفنية</label>
                    <select name="condition_status" class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800">
                        <option value="replaced">تم الاستبدال والتركيب</option>
                        <option value="needs_maintenance">يحتاج صيانة واستبدال</option>
                        <option value="critical_defect">عطل حرج</option>
                        <option value="repaired">تم الإصلاح الميداني</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">حالة السداد والتحصيل <span class="text-red-500">*</span></label>
                <select name="payment_status" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs font-bold text-slate-800">
                    <option value="unpaid">⚠️ غير مسدد (ينشئ تنبيه تحصيل تلقائي)</option>
                    <option value="paid">✓ مسدد من العميل</option>
                    <option value="covered_by_contract">مغطى بالعقد السنوي الشامل</option>
                </select>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">ملاحظات فنية</label>
                <textarea name="notes" rows="2" placeholder="ملاحظات حول سبب العطل أو مكان التركيب..." class="w-full bg-slate-50 border border-slate-300 rounded-xl p-2.5 text-xs"></textarea>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="document.getElementById('add-item-modal').close()" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl font-bold">إلغاء</button>
                <button type="submit" class="px-4 py-2 bg-amber-600 text-white rounded-xl font-bold">إضافة البند ✓</button>
            </div>
        </form>
    </dialog>

@endsection
