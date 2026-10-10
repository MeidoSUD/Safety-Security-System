<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'facility_id',
        'contract_id',
        'maintenance_request_id',
        'assigned_engineer_id',
        'assigned_supervisor_id',
        'visit_number',
        'visit_type',
        'scheduled_at',
        'location_zone',
        'visit_fee',
        'fee_status',
        'purpose',
        'status',
        'has_unpaid_parts',
        'unpaid_parts_amount',
        'unpaid_parts_notes',
        'notes',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'visit_fee' => 'decimal:2',
        'has_unpaid_parts' => 'boolean',
        'unpaid_parts_amount' => 'decimal:2',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function maintenanceRequest()
    {
        return $this->belongsTo(MaintenanceRequest::class);
    }

    public function engineer()
    {
        return $this->belongsTo(User::class, 'assigned_engineer_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'assigned_supervisor_id');
    }

    public function images()
    {
        return $this->hasMany(VisitImage::class);
    }

    public function items()
    {
        return $this->hasMany(VisitItem::class);
    }

    public function report()
    {
        return $this->hasOne(VisitReport::class);
    }

    public function getStatusArabicAttribute(): string
    {
        return match($this->status) {
            'scheduled' => 'مجدولة',
            'in_progress' => 'قيد التنفيذ الآن',
            'completed' => 'مكتملة',
            'cancelled' => 'ملغاة',
            default => $this->status,
        };
    }

    public function getTypeArabicAttribute(): string
    {
        return match($this->visit_type) {
            'emergency' => 'زيارة طارئة',
            'quarterly_inspection' => 'فحص ربع سنوي دوري',
            'pre_contract_audit' => 'معاينة ما قبل التعاقد',
            'corrective_maintenance' => 'صيانة تصحيحية وإصلاح أعطال',
            default => $this->visit_type,
        };
    }

    // Recalculate unpaid parts status automatically
    public function recalculateUnpaidParts()
    {
        $unpaidItems = $this->items()->where('payment_status', 'unpaid')->get();
        if ($unpaidItems->count() > 0) {
            $totalUnpaid = $unpaidItems->sum('total_price');
            $this->has_unpaid_parts = true;
            $this->unpaid_parts_amount = $totalUnpaid;
            $partsNames = $unpaidItems->pluck('item_name')->implode('، ');
            $this->unpaid_parts_notes = "⚠️ توجد قطع غيار تم تركيبها ولم يتم سدادها: ({$partsNames}) بمبلغ إجمالي {$totalUnpaid} ر.س";
        } else {
            $this->has_unpaid_parts = false;
            $this->unpaid_parts_amount = 0.00;
            $this->unpaid_parts_notes = null;
        }
        $this->save();
    }
}
