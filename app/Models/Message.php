<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'PENDING' => 'warning',
            'CONFIRMED' => 'success',
        ];

        return $badges[$this->status];
    }

    public function getTitleImageAttribute()
    {
        $title_images = [
            'NAGAD' => 'nagad.webp',
            'bKash' => 'bkash.webp',
            'Rocket' => 'rocket.webp',
            'upay' => 'upay.webp',
        ];

        return $title_images[preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $this->android_title)];
    }
}
