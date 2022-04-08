<?php

namespace App;

use App\Models\Setting;

class NullSetting extends Setting
{
    protected $attributes = [
        'site_name' => 'Lara Liveware',
        'site_title' => 'Laravel 8.x with Livewire Admin Panel.',
        'site_email' => 'example@mail.com',
        'site_phone' => '(88) 01761913331',
        'address' => '795 Folsom Ave, Suite 600',
        'country' => 'United States',
        'state' => 'Derrick Street',
        'city' => 'Boston',
        'zip_code' => 'CA 94107',
        'footer_text' => 'Copyright © 2021. All rights reserved.',
        'sidebar_collapse' => false,
    ];
}
