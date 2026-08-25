<?php

require_once 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

return
[
    'paths' => [
        'migrations' => './db/migrations',
        'seeds' => './db/seeds'
    ],
    'templates' => [
        'file' => './db/templates/MigrationTemplate.php.template'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => $_ENV['APP_ENV'] ?: 'dev',
        'production' => [
            'adapter' => 'pgsql',
            'host' => $_ENV['DB_HOST'],
            'name' => $_ENV['DB_NAME'],
            'user' => $_ENV['DB_USER'],
            'pass' => $_ENV['DB_PASSWORD'],
            'port' => $_ENV['DB_PORT'],
            'charset' => 'utf8',
        ],
        'dev' => [
            'adapter' => 'pgsql',
            'host' => $_ENV['DB_HOST'] ?: 'localhost',
            'name' => $_ENV['DB_NAME'] ?: 'my_cash_flow',
            'user' => $_ENV['DB_USER'] ?: 'dev',
            'pass' => $_ENV['DB_PASSWORD'] ?: 'pwd123',
            'port' => $_ENV['DB_PORT'] ?: '5432',
            'charset' => 'utf8',
        ],
        'testing' => [
            'adapter' => 'pgsql',
            'host' => $_ENV['DB_HOST'],
            'name' => $_ENV['DB_NAME'],
            'user' => $_ENV['DB_USER'],
            'pass' => $_ENV['DB_PASSWORD'],
            'port' => $_ENV['DB_PORT'],
            'charset' => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];
