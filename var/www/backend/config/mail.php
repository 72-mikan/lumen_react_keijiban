<?php

return [
    'driver' => env('MAIL_DRIVER', 'smtp'),
    'host' => env('MAIL_HOST', 'smtp.gmail.com'),// <-- 書き換え
    'port' => env('MAIL_PORT', 587),
    'from' => [
        'address' => 'shinzi7280@gmail.com',// <-- 書き換え
        'name' => 'test',// <-- 書き換え
    ],
    'encryption' => env('MAIL_ENCRYPTION', 'tls'),
    'username' => env('MAIL_USERNAME', 'shizi7280.18@gmail.com'),// <-- 書き換え
    'password' => env('MAIL_PASSWORD', 'gjwsxokjlpqttxhn'),// <-- 書き換え
    'sendmail' => '/usr/sbin/sendmail -bs',
];