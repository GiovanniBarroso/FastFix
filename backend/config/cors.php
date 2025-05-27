<?php

return [

    'paths' => [
        'api/*',
        'login',
        'logout',
        'register',
        'email/*',
        'sanctum/csrf-cookie',
        'api/paypal/success',
        'api/paypal/capture',
    ],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['http://localhost:5173'], // Solo tu frontend

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true, // 🔐 Imprescindible para JWT o cookies

];
