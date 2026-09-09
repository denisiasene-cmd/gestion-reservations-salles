<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = require dirname(__DIR__) . '/config/database.php';


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

foreach ($migrations as $migration) {

    $name = basename($migration);

    if (in_array($name, $executed, true)) {
        echo "Ignorée : {$name}" . PHP_EOL;
        continue;
    }

    require $migration;

    Capsule::table('migrations')->insert([
        'migration' => $name,
    ]);

    echo "Exécutée : {$name}" . PHP_EOL;
}
echo "Migrations terminées." . PHP_EOL;

