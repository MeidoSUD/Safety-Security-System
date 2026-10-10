<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'facility_id',
        'requester_id',
        'request_number',
        'type',
        'priority',
        'system_type',
        'title',
        'description',
        'site_photos',
        'status',
        'preferred_date',
    ];

    protected $casts = [
        'site_photos' => 'array',
        'preferred_date' => 'date',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function visit()
    {
        return $this->hasOne(Visit::class, 'maintenance_request_id');
    }

    public function getTypeArabicAttribute(): string
    {
        return match($this->type) {
            'emergency' => 'زيارة طارئة',
            'preventive' => 'صيانة وقائية',
            'inspection' => 'فحص ومعاينة',
            'quote_request' => 'طلب عرض سعر',
            default => $this->type,
        };
    }

    public function getPriorityBadgeColorAttribute(): string
    {
        return match($this->priority) {
            'critical' => 'bg-red-100 text-red-800 border-red-300',
            'high' => 'bg-amber-100 text-amber-800 border-amber-300',
            'medium' => 'bg-blue-100 text-blue-800 border-blue-300',
            'low' => 'bg-slate-100 text-slate-700 border-slate-300',
            default => 'bg-slate-100 text-slate-700 border-slate-300',
        };
    }
}
