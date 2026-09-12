<?php

declare(strict_types=1);

use Illuminate\Database\Capsule\Manager as Capsule;

class CreateUsersTable
{
    public function up(): void
    {
        Capsule::schema()->create('users', function ($table) {
            $table->id();
            $table->string('nom', 120);
            $table->string('prenom', 120);
            $table->string('role', 30);
            $table->string('password');
            $table->string('email', 255)->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Capsule::schema()->dropIfExists('users');
    }
}