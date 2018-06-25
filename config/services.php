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
    'firebase' => [
        'api_key' => 'AIzaSyBPXzcnKZ0QY81sJyibtYnMEE8WE97RlUA', // Only used for JS integration
        'auth_domain' => 'mycommute-891a4.firebaseapp.com', // Only used for JS integration
        'database_url' => 'https://mycommute-891a4.firebaseio.com/',
        'secret' => 'kOFFKOiDQGdZgfVcfceAP0RT0aY41j6FVD5qdiZq',
        'storage_bucket' => 'mycommute-891a4.appspot.com', // Only used for JS integration
    ],
    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_CALLBACK_URL'),
    ],
];
