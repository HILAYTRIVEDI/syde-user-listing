<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';


// Define the necessary WordPress functions for the testsz
if (!function_exists('sanitize_text_field')) {
    function sanitize_text_field($text)
    {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('absint')) {
    function absint($value)
    {
        return abs((int) $value);
    }
}

if (!function_exists('wp_unslash')) {
    function wp_unslash($string)
    {
        return stripslashes($string);
    }
}

if (!function_exists('sanitize_email')) {
    function sanitize_email($email)
    {
        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }
}

if (!function_exists('sanitize_url')) {
    function sanitize_url($url)
    {
        return filter_var($url, FILTER_SANITIZE_URL);
    }
}
