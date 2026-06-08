<?php

declare(strict_types=1);

return [
    'enabled' => true,
    'dev_server' => [
        'host' => '127.0.0.1',
        'port' => 5173,
        'https' => false,
        'timeout_ms' => 150,
    ],
    'input' => [
        'js' => 'resources/js/app.js',
        'css' => 'resources/css/app.css',
    ],
    'build_directory' => 'public/build',
    'build_url' => '/build',
    'manifest' => 'public/build/.vite/manifest.json',
];
