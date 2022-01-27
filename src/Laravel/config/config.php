<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Host
    |--------------------------------------------------------------------------
    |
    | The scheme + hostname that requests will be sent to.
    |
    | e.g. https://test-gateway.tillpayments.com
    |      https://gateway.tillpayments.com
    |
    */

    'host' => env('TILL_PAYMENTS_HOST', 'https://test-gateway.tillpayments.com'),

    /*
    |--------------------------------------------------------------------------
    | Username
    |--------------------------------------------------------------------------
    |
    | The user name of the Till-Payments account to be used.
    |
    */

    'username' => env('TILL_PAYMENTS_USERNAME', ''),

    /*
    |--------------------------------------------------------------------------
    | Password
    |--------------------------------------------------------------------------
    |
    | The password of the Till-Payments account.
    |
    */

    'password' => env('TILL_PAYMENTS_PASSWORD', ''),

    /*
    |--------------------------------------------------------------------------
    | API-Key
    |--------------------------------------------------------------------------
    |
    | The Till-Payments API key to use.
    |
    */

    'api_key' => env('TILL_PAYMENTS_API_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | The shared secret
    |--------------------------------------------------------------------------
    |
    | The Till-Payments API shared-secret to use.
    |
    */

    'shared_secret' => env('TILL_PAYMENTS_SHARED_SECRET', ''),

    /*
    |--------------------------------------------------------------------------
    | Request Signing
    |--------------------------------------------------------------------------
    |
    | When turned on, API requests will be signed. The signature is added
    | as an HTTP header.
    |
    */

    'add_signature' => env('TILL_PAYMENTS_ADD_SIGNATURE', true),

    /*
    |--------------------------------------------------------------------------
    | Public Integration Key
    |--------------------------------------------------------------------------
    |
    | The Till-Payments API public-integration-key to use.
    |
    */

    'public_integration_key' => env('TILL_PAYMENTS_PUBLIC_INTEGRATION_KEY', ''),
];
