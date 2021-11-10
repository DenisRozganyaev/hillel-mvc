<?php

if (!function_exists('h_secure_url')) {
    function h_secure_url($url) {
        return (app()->environment('local'))
            ? url($url)
            : secure_url($url);
    }
}

if (!function_exists('h_secure_asset')) {
    function h_secure_asset($url) {
        return (app()->environment('local'))
            ? asset($url)
            : secure_asset($url);
    }
}
