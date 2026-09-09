
<?php

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('reservations', function ($table) {
    $table->id();

    $table->foreignId('salle_id')
        ->constrained('salles');

    $table->string('responsable', 120);
    $table->string('email', 255);
    $table->string('motif', 255);

    $table->dateTime('date_debut');
    $table->dateTime('date_fin');

    $table->enum('statut', [
        'confirmée',
        'annulée',
    ])->default('confirmée');

    $table->timestamps();
});



