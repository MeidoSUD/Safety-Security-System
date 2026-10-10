<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'client_user_id',
        'name',
        'sector',
        'city',
        'district',
        'zone_type',
        'address',
        'contact_person',
        'contact_phone',
        'contact_email',
        'safety_license_number',
        'safety_license_expiry',
        'notes',
    ];

    protected $casts = [
        'safety_license_expiry' => 'date',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function clientUser()
    {
        return $this->belongsTo(User::class, 'client_user_id');
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function activeContract()
    {
        return $this->hasOne(Contract::class)->where('status', 'active')->latestOfMany();
    }

    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    public function getZoneLabelAttribute(): string
    {
        return $this->zone_type === 'inside_city' ? 'داخل نطاق المدينة' : 'خارج نطاق المدينة (موقع نائي)';
    }

    public function getSectorArabicAttribute(): string
    {
        return match($this->sector) {
            'industrial' => 'قطاع صناعي ومصانع',
            'educational' => 'قطاع تعليمي ومدارس',
            'medical' => 'قطاع طبي ومستشفيات',
            'commercial' => 'قطاع تجاري ومولات',
            'warehousing' => 'مستودعات ومناطق لوجستية',
            default => 'قطاع عام',
        };
    }
}
