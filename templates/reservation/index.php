<?php

/** @var \Illuminate\Pagination\LengthAwarePaginator $reservations */
/** @var string $recherche */
?>

<div class="page-header">

    <div>

        <h1 class="page-title">
            Réservations
        </h1>

        <p>
            Consultez les réservations enregistrées.
        </p>

    </div>

    <a
        href="/reservations/create"
        class="btn btn-primary"
    >
        + Nouvelle réservation
    </a>

</div>


<?php if (!empty($success)): ?>

    <div class="alert alert-success">

        <?= e_html($success) ?>

    </div>

<?php endif; ?>


<div class="card" style="margin-bottom: 30px;">

    <div class="card-body">

        <h2>
            Rechercher une réservation
        </h2>

        <form
            method="GET"
            action="/reservations"
        >

            <div>

                <label for="recherche">
                
                </label>

               <input
    type="text"
    id="recherche"
    name="recherche"
    value="<?= e_html($recherche ?? '') ?>"
    placeholder="Responsable ou motif"
   style="width: 100%; box-sizing: border-box; border: 1px solid; border-radius: 5px;margin-bottom: 30px;"
>

            </div>

            <div style="text-align: right;">

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Rechercher
                </button>

                <?php if (!empty($recherche)): ?>

                    <a
                        href="/reservations"
                        class="btn btn-secondary"
                    >
                        Réinitialiser
                    </a>

                <?php endif; ?>

            </div>

        </form>

    </div>

</div>


<?php if ($reservations->isEmpty()): ?>

    <div class="card">

        <div class="card-body">

            <h2>
                Aucune réservation
            </h2>

            <p>
                Aucune réservation ne correspond à votre recherche.
            </p>

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

                        <td>
                            <?= e_html($reservation->id) ?>
                        </td>

                        <td>
                            <?= e_html(
                                $reservation->salle->nom
                                ?? 'Salle #' . $reservation->salle_id
                            ) ?>
                        </td>

                        <td>

                            <?= e_html(
                                $reservation->responsable
                            ) ?>

                            <br>

                            <small>
                                <?= e_html(
                                    $reservation->email
                                ) ?>
                            </small>

                        </td>

                        <td>
                            <?= e_html(
                                $reservation->motif
                            ) ?>
                        </td>

                        <td>
                            <?= e_html(
                                $reservation->date_debut
                            ) ?>
                        </td>

                        <td>
                            <?= e_html(
                                $reservation->date_fin
                            ) ?>
                        </td>

                        <td>

                            <?php if (
                                $reservation->statut
                                === 'confirmée'
                            ): ?>

                                <span
                                    class="status status-confirmed"
                                >
                                    Confirmée
                                </span>

                            <?php else: ?>

                                <span
                                    class="status status-cancelled"
                                >
                                    Annulée
                                </span>

                            <?php endif; ?>

                        </td>

                        <td>

                            <a
                                href="/reservations/<?= e_html(
                                    $reservation->id
                                ) ?>"
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


    <div class="pagination">

        <?php if ($reservations->onFirstPage()): ?>

            <span class="btn btn-secondary">
                Précédent
            </span>

        <?php else: ?>

            <a
                href="<?= e_html(
                    $reservations->previousPageUrl()
                ) ?>"
                class="btn btn-secondary"
            >
                Précédent
            </a>

        <?php endif; ?>


        <?php if ($reservations->hasMorePages()): ?>

            <a
                href="<?= e_html(
                    $reservations->nextPageUrl()
                ) ?>"
                class="btn btn-primary"
            >
                Suivant
            </a>

        <?php else: ?>

            <span class="btn btn-secondary">
                Suivant
            </span>

        <?php endif; ?>

    </div>

<?php endif; ?>