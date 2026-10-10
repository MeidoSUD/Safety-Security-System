<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'company_id',
        'name',
        'email',
        'phone',
        'password',
        'role',
        'job_title',
        'avatar_emoji',
        'avatar_url',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function facilities()
    {
        return $this->hasMany(Facility::class, 'client_user_id');
    }

    public function requestedMaintenance()
    {
        return $this->hasMany(MaintenanceRequest::class, 'requester_id');
    }

    public function assignedVisitsAsEngineer()
    {
        return $this->hasMany(Visit::class, 'assigned_engineer_id');
    }

    public function assignedVisitsAsSupervisor()
    {
        return $this->hasMany(Visit::class, 'assigned_supervisor_id');
    }

    public function internalRequests()
    {
        return $this->hasMany(InternalRequest::class, 'requester_id');
    }

    public function notifications()
    {
        return $this->hasMany(SystemNotification::class);
    }

    // Role helpers
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isManager(): bool
    {
        return in_array($this->role, ['admin', 'manager']);
    }

    public function isSupervisor(): bool
    {
        return in_array($this->role, ['admin', 'manager', 'supervisor']);
    }

    public function isTechnician(): bool
    {
        return $this->role === 'technician';
    }

    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    public function getRoleArabicTitleAttribute(): string
    {
        return match($this->role) {
            'admin' => 'المدير التنفيذي (Admin)',
            'manager' => 'مدير العمليات والعقود',
            'supervisor' => 'مشرف الميدان والفنيين',
            'technician' => 'فني صيانة وشبكات',
            'client' => 'حساب العميل (منشأة/مدرسة)',
            default => 'مستخدم',
        };
    }
}
