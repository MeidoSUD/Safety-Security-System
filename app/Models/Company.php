<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cr_number',
        'tax_number',
        'email',
        'phone',
        'city',
        'address',
        'subscription_plan',
        'subscription_status',
        'logo',
        'zone_rate_inside',
        'zone_rate_outside',
        'sms_reminder_enabled',
    ];

    protected $casts = [
        'zone_rate_inside' => 'decimal:2',
        'zone_rate_outside' => 'decimal:2',
        'sms_reminder_enabled' => 'boolean',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function facilities()
    {
        return $this->hasMany(Facility::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    public function internalRequests()
    {
        return $this->hasMany(InternalRequest::class);
    }

    public function notifications()
    {
        return $this->hasMany(SystemNotification::class);
    }
}
