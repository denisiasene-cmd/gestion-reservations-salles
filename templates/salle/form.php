
<?php
/** @var array $old */
/** @var array $errors */
/** @var object|null $salle */

$old = $old ?? [];
$errors = $errors ?? [];

$modification = isset($salle);
?>

<div class="form-card">

    <div class="card">

        <div class="card-header">

            <h1>
                <?= $modification
                    ? 'Modifier la salle'
                    : 'Créer une salle' ?>
            </h1>

        </div>

        <div class="card-body">

            <form
                action="<?= $modification
                    ? '/salles/' . e($salle->id) . '/edit'
                    : '/salles' ?>"
                method="POST"
            >

                <div class="form-group">

                    <label for="nom" class="form-label">
                        Nom de la salle
                    </label>

                    <input
                        type="text"
                        id="nom"
                        name="nom"
                        class="form-control"
                        value="<?= e(
                            $old['nom']
                            ?? $salle->nom
                            ?? ''
                        ) ?>"
                    >

                    <?php if (isset($errors['nom'])): ?>
                        <div class="error-message">
                            <?= e($errors['nom'][0] ?? '') ?>
                        </div>
                    <?php endif; ?>

                </div>

                <div class="form-group">

                    <label for="batiment" class="form-label">
                        Bâtiment
                    </label>

                    <input
                        type="text"
                        id="batiment"
                        name="batiment"
                        class="form-control"
                        value="<?= e(
                            $old['batiment']
                            ?? $salle->batiment
                            ?? ''
                        ) ?>"
                    >

                    <?php if (isset($errors['batiment'])): ?>
                        <div class="error-message">
                            <?= e($errors['batiment'][0] ?? '') ?>
                        </div>
                    <?php endif; ?>

                </div>

                <div class="form-group">

                    <label for="capacite" class="form-label">
                        Capacité
                    </label>

                    <input
                        type="number"
                        id="capacite"
                        name="capacite"
                        class="form-control"
                        value="<?= e(
                            $old['capacite']
                            ?? $salle->capacite
                            ?? ''
                        ) ?>"
                    >

                    <?php if (isset($errors['capacite'])): ?>
                        <div class="error-message">
                            <?= e($errors['capacite'][0] ?? '') ?>
                        </div>
                    <?php endif; ?>

                </div>

                <div class="form-group">

                    <label for="type" class="form-label">
                        Type de salle
                    </label>

                    <select
                        id="type"
                        name="type"
                        class="form-select"
                    >

                        <option value="">
                            -- Sélectionner un type --
                        </option>

                        <?php

                        $types = [
                            'cours' => 'Cours',
                            'informatique' => 'Informatique',
                            'laboratoire' => 'Laboratoire',
                            'amphitheatre' => 'Amphithéâtre',
                            'reunion' => 'Réunion'
                        ];

                        ?>

                        <?php foreach ($types as $valeur => $libelle): ?>

                            <option
                                value="<?= e($valeur) ?>"
                                <?= (
                                    $old['type']
                                    ?? $salle->type
                                    ?? ''
                                ) === $valeur
                                    ? 'selected'
                                    : '' ?>
                            >
                                <?= e($libelle) ?>
                            </option>

                        <?php endforeach; ?>

                    </select>

                    <?php if (isset($errors['type'])): ?>
                        <div class="error-message">
                            <?= e($errors['type'][0] ?? '') ?>
                        </div>
                    <?php endif; ?>

                </div>

                <?php if ($modification): ?>

                    <div class="form-group">

                        <label class="form-label">
                            État de la salle
                        </label>

                        <label>

                            <input
                                type="checkbox"
                                name="active"
                                value="1"
                                <?= !empty(
                                    $old['active']
                                    ?? $salle->active
                                )
                                    ? 'checked'
                                    : '' ?>
                            >

                            Salle active

                        </label>

                    </div>

                <?php endif; ?>

                <div class="form-actions">

                    <a
                        href="/salles"
                        class="btn btn-outline"
                    >
                        Annuler
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        <?= $modification
                            ? 'Enregistrer les modifications'
                            : 'Créer la salle' ?>
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

