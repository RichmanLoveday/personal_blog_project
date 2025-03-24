<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie', '*'], // Allow all paths
    'allowed_methods' => ['*'], // Allow all HTTP methods
    'allowed_origins' => ['http://127.0.0.1:8000', 'http://localhost:8000'], // Remove trailing "/"
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'], // Allow all headers
    'exposed_headers' => ['Authorization', 'X-Custom-Header'],
    'max_age' => 3600,
    'supports_credentials' => true,

];
