<?php

use Dotenv\Dotenv;

it('loads essential environment variables', function () {
    $path = dirname(__DIR__, 2);
    $env = Dotenv::createArrayBacked($path, '.env.example')->load();

    $keys = [
        'APP_URL',
        'SESSION_DOMAIN',
        'SANCTUM_STATEFUL_DOMAINS',
        'DB_CONNECTION',
        'DB_HOST',
        'DB_PORT',
        'DB_DATABASE',
        'DB_USERNAME',
        'DB_PASSWORD',
        'REDIS_HOST',
        'REDIS_PASSWORD',
        'REDIS_PORT',
        'FILESYSTEM_DISK',
    ];

    foreach ($keys as $key) {
        expect($env[$key] ?? null)->not->toBeNull()->and($env[$key])->not->toBe('');
    }
});
