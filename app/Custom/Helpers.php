<?php

use App\Models\Setting;
use App\NullSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

function setting($key)
{
    $setting = Cache::rememberForever('setting', function() {
        return Setting::query()->first() ?? NullSetting::make();
    });

    if ($setting) {
        return  $setting->{$key};
    }
}

function toFormattedNumber($number, $accept_decimal = null) {
    if ($accept_decimal) {
        return number_format((float)$number, $accept_decimal, '.', '');
    }
    return round($number);
}

function checkInfinity($value) {
    if ($value >= 0) {
        return $value;
    }
    return '<small><i class="fas fa-infinity"></i></small>';
}

function toFormattedSlug($value) {
    $value = Str::replace(' ', '-', $value);
    return preg_replace('/[^A-Za-z0-9\-]/', '', $value); // Removes special chars.
}
