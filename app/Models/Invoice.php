<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function invoiceDetails()
    {
        return $this->hasMany(InvoiceDetail::class, 'invoice_id');
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class, 'tax_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            1 => 'success',
            2 => 'primary',
            3 => 'warning',
        ];

        return $badges[$this->status];
    }

    public function getStatusNameAttribute()
    {
        $names = [
            1 => 'PAID',
            2 => 'PARTIAL PAID',
            3 => 'DUE',
        ];

        return $names[$this->status];
    }
}
