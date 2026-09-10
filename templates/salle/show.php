
<?php
/** @var object $salle */
?>

<div class="detail-card">

    <div class="card">

        <div class="card-header">

            <h1>
                <?= e_html($salle->nom) ?>
            </h1>

        </div>

        <div class="card-body">

            <dl class="detail-list">

                <dt>Bâtiment</dt>
                <dd><?= e_html($salle->batiment) ?></dd>

                <dt>Capacité</dt>
                <dd><?= e_html($salle->capacite) ?> personnes</dd>

                <dt>Type</dt>
                <dd><?= e_html($salle->type) ?></dd>

                <dt>Statut</dt>

                <dd>

                    <?php if ($salle->active): ?>

                        <span class="status status-active">
                            Active
                        </span>

                    <?php else: ?>

                        <span class="status status-inactive">
                            Inactive
                        </span>

                    <?php endif; ?>

                </dd>

            </dl>

        </div>

        <div class="card-footer">

            <a
                href="/salles"
                class="btn btn-outline"
            >
                ← Retour aux salles
            </a>

            <a
                href="/salles/<?= e_html($salle->id) ?>/edit"
                class="btn btn-secondary"
            >
                Modifier
            </a>

        </div>

    </div>

</div>

