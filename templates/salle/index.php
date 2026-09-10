
<?php
/** @var array $salles */
?>

<div class="page-header">

    <h1 class="page-title">
        Nos salles
    </h1>

    <a
        href="/salles/create"
        class="btn btn-primary"
    >
        + Nouvelle salle
    </a>

</div>

<?php if (empty($salles)): ?>

    <div class="card">

        <div class="card-body">
            <p>Aucune salle n'est enregistrée.</p>
        </div>

    </div>

<?php else: ?>

    <div class="salles-grid">

        <?php foreach ($salles as $salle): ?>

            <article class="card salle-card">

                <div class="card-body">

                    <h2 class="salle-name">
                        <?= e_html($salle->nom) ?>
                    </h2>

                    <p class="salle-info">
                        Bâtiment :
                        <?= e_html($salle->batiment) ?>
                    </p>

                    <p class="salle-info">
                        Capacité :
                        <strong>
                            <?= e_html($salle->capacite) ?>
                        </strong>
                        personnes
                    </p>

                    <p class="salle-info">
                        Type :
                        <?= e_html($salle->type) ?>
                    </p>

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

<?php endif; ?>

