<?php

return [
    'api_url' => env('HAP_API_URL', 'http://localhost:8000/api'),
    'api_timeout' => (int) env('HAP_API_TIMEOUT', 15),
];
