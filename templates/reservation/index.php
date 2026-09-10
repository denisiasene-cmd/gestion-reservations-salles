
<?php
/** @var array $reservations */
?>

<div class="page-header">

    <h1 class="page-title">
        Réservations
    </h1>

    <a
        href="/reservations/create"
        class="btn btn-primary"
    >
        + Nouvelle réservation
    </a>

</div>

<?php if (empty($reservations)): ?>

    <div class="card">

        <div class="card-body">
            <p>Aucune réservation n'est enregistrée.</p>
        </div>

    </div>

<?php else: ?>

    <div class="card">

        <div class="table-container">

            <table>

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Salle</th>
                        <th>Responsable</th>
                        <th>Motif</th>
                        <th>Début</th>
                        <th>Fin</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                <?php foreach ($reservations as $reservation): ?>

                    <tr>

                        <td><?= e($reservation->id) ?></td>

                        <td>
                            <?= e(
                                $reservation->salle->nom
                                ?? 'Salle #' . $reservation->salle_id
                            ) ?>
                        </td>

                        <td>
                            <?= e($reservation->responsable) ?>
                            <br>
                            <small>
                                <?= e($reservation->email) ?>
                            </small>
                        </td>

                        <td><?= e($reservation->motif) ?></td>

                        <td><?= e($reservation->date_debut) ?></td>

                        <td><?= e($reservation->date_fin) ?></td>

                        <td>

                            <?php if ($reservation->statut === 'confirmée'): ?>

                                <span class="status status-confirmed">
                                    Confirmée
                                </span>

                            <?php else: ?>

                                <span class="status status-cancelled">
                                    Annulée
                                </span>

                            <?php endif; ?>

                        </td>

                        <td>

                            <a
                                href="/reservations/<?= e($reservation->id) ?>"
                                class="btn btn-outline"
                            >
                                Détails
                            </a>

                        </td>

                    </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

<?php endif; ?>

