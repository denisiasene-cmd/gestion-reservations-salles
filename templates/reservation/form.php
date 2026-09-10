
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
                                    value="<?= e($salle->id) ?>"
                                    <?= ($old['salle_id'] ?? '') == $salle->id
                                        ? 'selected'
                                        : '' ?>
                                >
                                    <?= e($salle->nom) ?>
                                    — <?= e($salle->batiment) ?>
                                    (<?= e($salle->capacite) ?> places)
                                </option>

                            <?php endif; ?>

                        <?php endforeach; ?>

                    </select>

                    <?php if (isset($errors['salle_id'])): ?>
                        <div class="error-message">
                            <?= e($errors['salle_id'][0] ?? '') ?>
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
                        value="<?= e($old['responsable'] ?? '') ?>"
                    >

                    <?php if (isset($errors['responsable'])): ?>
                        <div class="error-message">
                            <?= e($errors['responsable'][0] ?? '') ?>
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
                        value="<?= e($old['email'] ?? '') ?>"
                    >

                    <?php if (isset($errors['email'])): ?>
                        <div class="error-message">
                            <?= e($errors['email'][0] ?? '') ?>
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
                    ><?= e($old['motif'] ?? '') ?></textarea>

                    <?php if (isset($errors['motif'])): ?>
                        <div class="error-message">
                            <?= e($errors['motif'][0] ?? '') ?>
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
                        value="<?= e($old['date_debut'] ?? '') ?>"
                    >

                    <?php if (isset($errors['date_debut'])): ?>
                        <div class="error-message">
                            <?= e($errors['date_debut'][0] ?? '') ?>
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
                        value="<?= e($old['date_fin'] ?? '') ?>"
                    >

                    <?php if (isset($errors['date_fin'])): ?>
                        <div class="error-message">
                            <?= e($errors['date_fin'][0] ?? '') ?>
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

