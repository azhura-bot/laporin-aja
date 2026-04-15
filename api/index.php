<?php

declare(strict_types=1);

/**
 * Vercel functions use read-only filesystem except /tmp.
 * Ensure Laravel runtime writable dirs exist for compiled views and temp storage.
 * Also route Laravel cache manifests to /tmp so provider discovery can work.
 */
$writableDirs = [
    '/tmp/bootstrap/cache',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
];

foreach ($writableDirs as $dir) {
    if (! is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
}

$runtimeEnvDefaults = [
    'LARAVEL_STORAGE_PATH' => '/tmp/storage',
    'VIEW_COMPILED_PATH' => '/tmp/storage/framework/views',
    'APP_CONFIG_CACHE' => '/tmp/bootstrap/cache/config.php',
    'APP_EVENTS_CACHE' => '/tmp/bootstrap/cache/events.php',
    'APP_PACKAGES_CACHE' => '/tmp/bootstrap/cache/packages.php',
    'APP_ROUTES_CACHE' => '/tmp/bootstrap/cache/routes-v7.php',
    'APP_SERVICES_CACHE' => '/tmp/bootstrap/cache/services.php',
];

foreach ($runtimeEnvDefaults as $key => $value) {
    if (! getenv($key)) {
        putenv("{$key}={$value}");
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}

require __DIR__ . '/../public/index.php';
