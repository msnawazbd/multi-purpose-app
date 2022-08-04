<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class City extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = [
        'featured_image_url'
    ];

    public function getFeaturedImageUrlAttribute()
    {
        if ($this->featured_image && Storage::disk('city_featured_images')->exists($this->featured_image)) {
            return Storage::disk('city_featured_images')->url($this->featured_image);
        }

        return 'https://ui-avatars.com/api/?name=' . $this->city_name;
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
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
