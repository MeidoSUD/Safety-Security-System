<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'visit_id',
        'facility_id',
        'uploaded_by_user_id',
        'image_path',
        'caption',
        'stage',
    ];

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by_user_id');
    }

    public function getStageArabicAttribute(): string
    {
        return match($this->stage) {
            'before_work' => 'قبل بدء الصيانة',
            'during_inspection' => 'أثناء الفحص الميداني',
            'after_work' => 'بعد إنجاز العمل',
            'defect_evidence' => 'توثيق العطل / ملاحظة فنية',
            default => $this->stage,
        };
    }
}
