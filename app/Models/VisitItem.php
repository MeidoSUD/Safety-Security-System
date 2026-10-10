<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'visit_id',
        'item_name',
        'item_category',
        'quantity',
        'unit_price',
        'total_price',
        'condition_status',
        'payment_status',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    protected static function booted()
    {
        static::saved(function ($item) {
            $item->visit?->recalculateUnpaidParts();
        });

        static::deleted(function ($item) {
            $item->visit?->recalculateUnpaidParts();
        });
    }

    public function getCategoryArabicAttribute(): string
    {
        return match($this->item_category) {
            'pump_part' => 'قطع مضخات حريق',
            'alarm_part' => 'قطع شبكة إنذار',
            'sprinkler_part' => 'قطع شبكة رشاشات',
            'extinguisher' => 'طفايات حريق',
            'general_spare' => 'قطع غيار عامة',
            'labor' => 'أجور يد وفحص فني',
            default => 'مستلزمات صيانة',
        };
    }

    public function getConditionArabicAttribute(): string
    {
        return match($this->condition_status) {
            'good' => 'سليم / تم الفحص',
            'needs_maintenance' => 'يحتاج صيانة واستبدال',
            'replaced' => 'تم الاستبدال بنجاح',
            'critical_defect' => 'عطل حرج يستوجب الإيقاف',
            'repaired' => 'تم الإصلاح الميداني',
            default => $this->condition_status,
        };
    }
}
