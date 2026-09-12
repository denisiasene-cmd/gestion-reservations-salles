
<?php
/** @var object $reservation */
?>

<div class="detail-card">

    <div class="card">

        <div class="card-header">

            <h1>
                Réservation #<?= e_html($reservation->id) ?>
            </h1>

            <p>
                Informations détaillées de la réservation.
            </p>

        </div>


        <div class="card-body">

            <dl class="detail-list">

                <dt>Salle</dt>

                <dd>
                    <?= e_html($reservation->salle->nom ?? 'Salle #' . $reservation->salle_id) ?>
                </dd>


                <dt>Responsable</dt>

                <dd>
                    <?= e_html($reservation->responsable) ?>
                </dd>


                <dt>Email</dt>

                <dd>
                    <?= e_html($reservation->email) ?>
                </dd>


                <dt>Motif</dt>

                <dd>
                    <?= e_html($reservation->motif) ?>
                </dd>


                <dt>Date de début</dt>

                <dd>
                    <?= e_html($reservation->date_debut) ?>
                </dd>


                <dt>Date de fin</dt>

                <dd>
                    <?= e_html($reservation->date_fin) ?>
                </dd>


                <dt>Statut</dt>

                <dd>

                    <?php if ($reservation->statut === 'confirmée'): ?>

                        <span class="status status-confirmed">
                            Confirmée
                        </span>

                    <?php else: ?>

                        <span class="status status-cancelled">
                            Annulée
                        </span>

                    <?php endif; ?>

                </dd>

            </dl>

        </div>


        <div class="card-footer">

            <a
                href="/reservations"
                class="btn btn-outline"
            >
                ← Retour aux réservations
            </a>


            <?php if ($reservation->statut === 'confirmée'): ?>

                <form
                    action="/reservations/<?= e_html($reservation->id) ?>/cancel"
                    method="POST"
                    style="display: inline;"
                >

                    <button
                        type="submit"
                        class="btn btn-danger"
                    >
                        Annuler la réservation
                    </button>

                </form>

            <?php endif; ?>

        </div>

    </div>

</div>