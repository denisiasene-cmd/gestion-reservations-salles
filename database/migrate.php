<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

require dirname(__DIR__) . '/config/database.php';

$migrationsPath = dirname(__DIR__) . '/database/migrations';

if (!Capsule::schema()->hasTable('migrations')) {
    Capsule::schema()->create('migrations', function ($table) {
        $table->id();
        $table->string('migration')->unique();
        $table->timestamp('executed_at')->useCurrent();
    });
}

$executed = Capsule::table('migrations')
    ->pluck('migration')
    ->all();

$migrations = glob($migrationsPath . '/*.php');

sort($migrations);

foreach ($migrations as $migrationFile) {
    $name = basename($migrationFile);

    if (in_array($name, $executed, true)) {
        echo "Ignorée : {$name}" . PHP_EOL;
        continue;
    }

    require_once $migrationFile;

    $classes = [
        '01_create_salles.php' => CreateSallesTable::class,
        '02_create_reservations.php' => CreateReservationsTable::class,
        '03_create_users.php' => CreateUsersTable::class,
    ];

    if (!isset($classes[$name])) {
        throw new RuntimeException(
            "Classe de migration inconnue : {$name}"
        );
    }

    $migration = new $classes[$name]();

    $migration->up();

    Capsule::table('migrations')->insert([
        'migration' => $name,
    ]);

    echo "Exécutée : {$name}" . PHP_EOL;
}

echo "Migrations terminées." . PHP_EOL;