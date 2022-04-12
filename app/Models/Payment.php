<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'receiving_date' => 'datetime',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function getReceivingDateAttribute($value)
    {
        return Carbon::parse($value)->toFormattedDate();
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->toFormattedDate();
    }
}
