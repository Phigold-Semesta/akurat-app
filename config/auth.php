<?php

use App\Models\User;

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    | Menetapkan guard default ke 'internal' untuk aplikasi AKURAT.
    */

    'defaults' => [
        'guard' => 'internal',
        'passwords' => 'user',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    | Memisahkan 'internal' dan 'koperasi' untuk menjaga keamanan session
    | agar tidak saling tumpang tindih.
    */

    'guards' => [
        'internal' => [
            'driver' => 'session',
            'provider' => 'user',
        ],

        'koperasi' => [
            'driver' => 'session',
            'provider' => 'user',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    | Menggunakan 'user' sebagai provider tunggal karena keduanya 
    | mengacu pada tabel 'user' (singular) di database.
    */

    'providers' => [
        'user' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', User::class),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    */

    'passwords' => [
        'user' => [
            'provider' => 'user',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];