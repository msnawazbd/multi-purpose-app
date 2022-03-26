<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function countryInfo()
    {
        return $this->belongsTo(Country::class. 'country_id');
    }

    public function getfullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
