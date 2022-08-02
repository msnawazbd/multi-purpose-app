<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
