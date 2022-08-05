<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

if (!function_exists('greeting')) {
    function greeting($name)
    {
        $timing = '';

        $time = date('H');

        if ($time < '12') {
            $timing = 'Pagi';
        } else if ($time >= '12' && $time < '17') {
            $timing = 'Siang';
        } else if ($time >= '17' && $time < '19') {
            $timing = 'Sore';
        } else if ($time >= '19') {
            $timing = 'Malam';
        }

        return $timing . ', ' . Str::words($name, 2);
    }
}
