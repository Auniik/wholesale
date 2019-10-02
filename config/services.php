<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'sms' => [
        'api' => 'https://api.mobireach.com.bd',
        'send' => '/SendTextMessage',
        'username' => env('SMS_USERNAME'),
        'password' => env('SMS_PASSWORD'),
        'from' => env('SMS_FROM'),
    ],
    'attendance' => [
        'api' => 'http://104.168.253.39/',
//        'fetch' => '/SendTextMessage',
        'userId' => env('USER_ID'),
        'from' => env('ATTENDANCE_FROM'),
        'to' => env('ATTENDANCE_TO'),
        'startTime' => env('START_TIME'),
        'endTime' => env('END_TIME'),
    ]
];
