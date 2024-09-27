<?php
// tests/bootstrap.php

// Load Composer's autoloader from the root directory
require __DIR__ . '/../vendor/autoload.php';

// Load environment variables using Dotenv
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Ensure the environment is set to testing
putenv('APP_ENV=test');
putenv('APP_DEBUG=0');

// You can also set other environment variables needed for your tests here
putenv('DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name');

// Optionally clear the cache before running tests
if (is_dir(__DIR__ . '/../var/cache')) {
    array_map('unlink', glob(__DIR__ . '/../var/cache/*'));
}

// Any other setup steps you need can be added here