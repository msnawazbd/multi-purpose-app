<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'start_date' => 'datetime',
        'deadline' => 'datetime'
    ];

    public function getPriorityBadgeAttribute()
    {
        $badges = [
            'LOW' => 'info',
            'MEDIUM' => 'primary',
            'HIGH' => 'warning',
            'URGENT' => 'danger',
        ];

        return $badges[$this->priority];
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'NOT STARTED' => 'warning',
            'IN PROGRESS' => 'primary',
            'COMPLETED' => 'success',
            'DEFERRED' => 'danger',
        ];

        return $badges[$this->status];
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'task_user', 'task_id', 'user_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getStartDateAttribute($value)
    {
        return Carbon::parse($value)->toFormattedDate();
    }

    public function getDeadlineAttribute($value)
    {
        return Carbon::parse($value)->toFormattedDate();
    }

}
