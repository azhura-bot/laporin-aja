<?php

declare(strict_types=1);

/**
 * Vercel functions use read-only filesystem except /tmp.
 * Ensure Laravel runtime writable dirs exist for compiled views and temp storage.
 */
$writableDirs = [
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

require __DIR__ . '/../public/index.php';
