<?php

return [
    'storage' => [
        'path' => env('WAREHOUSE_STORAGE_PATH', storage_path('app')),
    ],

    'admin' => [
        'path' => env('WAREHOUSE_ADMIN_PATH', '/'),
    ],
];
