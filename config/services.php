<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'whatspie' => [
        'url'               => env('WHATSPIE_API_URL'),
        'secret'            => env('WHATSPIE_SECRET_KEY'),
        'group'             => env('WHATSPIE_GROUP_ID'),
        'session'           => env('SESSION_ID_WA'),
        'connect_timeout'   => (int) env('WHATSPIE_CONNECT_TIMEOUT', 5),
        'timeout'           => (int) env('WHATSPIE_TIMEOUT', 30),
    ]

];
