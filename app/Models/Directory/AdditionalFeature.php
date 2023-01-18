<?php

namespace App\Models\Directory;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalFeature extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function listing()
    {
        return $this->belongsTo(Listing::class, 'listing_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
