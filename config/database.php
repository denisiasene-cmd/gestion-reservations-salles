<?php

declare(strict_types=1);

use Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager as Capsule;

$racine = dirname(__DIR__);

Dotenv::createImmutable($racine)->safeLoad();

$capsule = new Capsule();

$capsule->addConnection([
    'driver' => $_ENV['DB_DRIVER'],
    'host' => $_ENV['DB_HOST'],
    'port' => $_ENV['DB_PORT'],
    'database' => $_ENV['DB_DATABASE'],
    'username' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD'],
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'options' => [
        \PDO::MYSQL_ATTR_SSL_CA => $racine . '/config/certs/ca.pem',
        \PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => true,
    ],
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

return $capsule;

