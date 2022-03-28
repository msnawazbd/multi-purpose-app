<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'start_date' => 'date',
        'deadline' => 'date'
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

    public function usersInfo()
    {
        return $this->belongsToMany(User::class, 'task_user', 'task_id', 'user_id');
    }
}
