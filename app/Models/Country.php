<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function clients()
    {
        return $this->hasMany(Client::class, 'client_id');
    }

    public function states()
    {
        return $this->hasMany(State::class, 'country_id', 'id');
    }
}
