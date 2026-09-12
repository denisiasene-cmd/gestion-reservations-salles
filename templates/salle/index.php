
<?php
/** @var \Illuminate\Pagination\LengthAwarePaginator $salles */
?>

<div class="page-header">

    <div>
        <h1 class="page-title">
            Nos salles
        </h1>

        <p class="page-subtitle">
            Découvrez les salles disponibles et leur capacité.
        </p>
    </div>

    <a
        href="/salles/create"
        class="btn btn-primary"
    >
        + Nouvelle salle
    </a>

</div>
<?php if ($salles->isEmpty()): ?>

    <div class="card empty-state">

        <div class="card-body">

            <h2>
                Aucune salle
            </h2>

            <p>
                Aucune salle n'est enregistrée pour le moment.
            </p>

            <a
                href="/salles/create"
                class="btn btn-primary"
            >
                Créer une salle
            </a>

        </div>

    </div>
<?php else: ?>

    <div class="salles-grid">

        <?php foreach ($salles as $salle): ?>

            <article class="card salle-card">

                <div class="card-body">

                    <div class="salle-card-header">

                        <h2 class="salle-name">
                            <?= e_html($salle->nom) ?>
                        </h2>

                        <?php if ($salle->active): ?>

                            <span class="status status-active">
                                Active
                            </span>

                        <?php else: ?>

                            <span class="status status-inactive">
                                Inactive
                            </span>

                        <?php endif; ?>

                    </div>


                    <div class="salle-details">

                        <p class="salle-info">

                            <span>
                                Bâtiment
                            </span>

                            <strong>
                                <?= e_html($salle->batiment) ?>
                            </strong>

                        </p>


                        <p class="salle-info">

                            <span>
                                Capacité
                            </span>

                            <strong>
                                <?= e_html($salle->capacite) ?>
                                personnes
                            </strong>

                        </p>


                        <p class="salle-info">

                            <span>
                                Type
                            </span>

                            <strong>
                                <?= e_html($salle->type) ?>
                            </strong>

                        </p>

                    </div>

                </div>


                <div class="card-footer">

                    <a
                        href="/salles/<?= e_html($salle->id) ?>"
                        class="btn btn-outline"
                    >
                        Détails
                    </a>

                    <a
                        href="/salles/<?= e_html($salle->id) ?>/edit"
                        class="btn btn-secondary"
                    >
                        Modifier
                    </a>

                </div>

            </article>

        <?php endforeach; ?>

    </div>


    <div class="pagination">

        <?php if ($salles->onFirstPage()): ?>

            <span class="btn btn-secondary">
                Précédent
            </span>

        <?php else: ?>

            <a
                href="<?= e_html($salles->previousPageUrl()) ?>"
                class="btn btn-secondary"
            >
                Précédent
            </a>

        <?php endif; ?>


        <?php if ($salles->hasMorePages()): ?>

            <a
                href="<?= e_html($salles->nextPageUrl()) ?>"
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
