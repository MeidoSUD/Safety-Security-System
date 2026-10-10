<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'requester_id',
        'department_from',
        'department_to',
        'request_type',
        'title',
        'description',
        'priority',
        'status',
        'reviewed_by_id',
        'review_notes',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by_id');
    }
}
