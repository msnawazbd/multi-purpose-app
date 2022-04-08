<?php

use App\Models\Setting;
use App\NullSetting;
use Illuminate\Support\Facades\Cache;

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
