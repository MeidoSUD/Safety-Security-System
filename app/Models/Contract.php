<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'facility_id',
        'contract_number',
        'title',
        'contract_type',
        'start_date',
        'end_date',
        'total_amount',
        'visits_quota',
        'visits_used',
        'status',
        'attachment_path',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    public function getStatusArabicAttribute(): string
    {
        return match($this->status) {
            'active' => 'عقد ساري',
            'expiring_soon' => 'ينتهي قريباً',
            'expired' => 'منتهي الصلاحية',
            'cancelled' => 'ملغي',
            default => 'غير محدد',
        };
    }
}
