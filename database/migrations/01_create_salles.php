<?php

declare(strict_types=1);

use Illuminate\Database\Capsule\Manager as Capsule;

class CreateSallesTable
{
    public function up(): void
    {
        Capsule::schema()->create('salles', function ($table) {
            $table->id();
            $table->string('nom', 100);
            $table->string('batiment', 100);
            $table->unsignedInteger('capacite');

            $table->enum('type', [
                'cours',
                'informatique',
                'laboratoire',
                'amphitheatre',
                'reunion',
            ]);

            $table->boolean('active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Capsule::schema()->dropIfExists('salles');
    }
}