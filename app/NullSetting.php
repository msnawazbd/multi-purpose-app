<?php

namespace App;

use App\Models\Setting;

class NullSetting extends Setting
{
    protected $attributes = [
        'site_name' => 'Lara Liveware',
        'site_email' => 'example@mail.com',
        'site_title' => 'Laravel 8.x with Livewire Admin Panel.',
        'footer_text' => 'Copyright © 2021. All rights reserved.',
        'sidebar_collapse' => false,
    ];
}
