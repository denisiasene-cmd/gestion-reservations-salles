
<?php
/** @var array $salles */
/** @var array $old */
/** @var array $errors */

$salles = $salles ?? [];
$old = $old ?? [];
$errors = $errors ?? [];
?>

<div class="form-card">

    <div class="card">

        <div class="card-header">
            <h1>Nouvelle réservation</h1>
        </div>

        <div class="card-body">

            <form action="/reservations" method="POST">

                <div class="form-group">
                    <label for="salle_id" class="form-label">
                        Salle
                    </label>

                    <select id="salle_id" name="salle_id" class="form-select">

                        <option value="">
                            -- Choisir une salle --
                        </option>

                        <?php foreach ($salles as $salle): ?>

                            <?php if ($salle->active): ?>

                                <option
                                    value="<?= e_html($salle->id) ?>"
                                    <?= ($old['salle_id'] ?? '') == $salle->id
                                        ? 'selected'
                                        : '' ?>
                                >
                                    <?= e_html($salle->nom) ?>
                                    — <?= e_html($salle->batiment) ?>
                                    (<?= e_html($salle->capacite) ?> places)
                                </option>

                            <?php endif; ?>

                        <?php endforeach; ?>

                    </select>

                    <?php if (isset($errors['salle_id'])): ?>
                        <div class="error-message">
                            <?= e_html($errors['salle_id'] ?? '') ?>
                        </div>
                    <?php endif; ?>

                </div>

                <div class="form-group">

                    <label for="responsable" class="form-label">
                        Responsable
                    </label>

                    <input
                        type="text"
                        id="responsable"
                        name="responsable"
                        class="form-control"
                        value="<?= e_html($old['responsable'] ?? '') ?>"
                    >

                    <?php if (isset($errors['responsable'])): ?>
                        <div class="error-message">
                            <?= e_html($errors['responsable'] ?? '') ?>
                        </div>
                    <?php endif; ?>

                </div>

                <div class="form-group">

                    <label for="email" class="form-label">
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        value="<?= e_html($old['email'] ?? '') ?>"
                    >

                    <?php if (isset($errors['email'])): ?>
                        <div class="error-message">
                            <?= e_html($errors['email'] ?? '') ?>
                        </div>
                    <?php endif; ?>

                </div>

                <div class="form-group">

                    <label for="motif" class="form-label">
                        Motif
                    </label>

                    <textarea
                        id="motif"
                        name="motif"
                        class="form-control"
                    ><?= e_html($old['motif'] ?? '') ?></textarea>

                    <?php if (isset($errors['motif'])): ?>
                        <div class="error-message">
                            <?= e_html($errors['motif'] ?? '') ?>
                        </div>
                    <?php endif; ?>

                </div>

                <div class="form-group">

                    <label for="date_debut" class="form-label">
                        Date et heure de début
                    </label>

                    <input
                        type="datetime-local"
                        id="date_debut"
                        name="date_debut"
                        class="form-control"
                        value="<?= e_html($old['date_debut'] ?? '') ?>"
                    >

                    <?php if (isset($errors['date_debut'])): ?>
                        <div class="error-message">
                            <?= e_html($errors['date_debut'] ?? '') ?>
                        </div>
                    <?php endif; ?>

                </div>

                <div class="form-group">

                    <label for="date_fin" class="form-label">
                        Date et heure de fin
                    </label>

                    <input
                        type="datetime-local"
                        id="date_fin"
                        name="date_fin"
                        class="form-control"
                        value="<?= e_html($old['date_fin'] ?? '') ?>"
                    >

                    <?php if (isset($errors['date_fin'])): ?>
                        <div class="error-message">
                            <?= e_html($errors['date_fin'] ?? '') ?>
                        </div>
                    <?php endif; ?>

                </div>

                <div class="form-actions">

                    <a href="/reservations" class="btn btn-outline">
                        Annuler
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Confirmer la réservation
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
