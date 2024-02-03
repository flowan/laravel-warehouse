<?php

return [
    'version' => '0.1.0',

    'storage' => [
        'path' => env('WAREHOUSE_STORAGE_PATH', storage_path('app')),
    ],

    'admin' => [
        'path' => env('WAREHOUSE_ADMIN_PATH', '/'),
    ],
];
