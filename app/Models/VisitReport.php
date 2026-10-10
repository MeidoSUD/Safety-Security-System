<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'visit_id',
        'engineer_id',
        'report_number',
        'summary',
        'overall_status',
        'checklist_results',
        'recommendations',
        'engineer_notes',
        'client_signature_name',
        'pdf_path',
        'status',
        'approved_by_user_id',
        'approved_at',
    ];

    protected $casts = [
        'checklist_results' => 'array',
        'approved_at' => 'datetime',
    ];

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    public function engineer()
    {
        return $this->belongsTo(User::class, 'engineer_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by_user_id');
    }

    public function getOverallStatusArabicAttribute(): string
    {
        return match($this->overall_status) {
            'passed' => 'مطابق لمعايير السلامة (ناجح)',
            'passed_with_notes' => 'مطابق مع وجود ملاحظات تشغيلية',
            'critical_action_required' => 'يتطلب إجراء عاجل وفوري',
            'failed' => 'غير مطابق لمعايير الدفاع المدني (راسب)',
            default => $this->overall_status,
        };
    }
}
