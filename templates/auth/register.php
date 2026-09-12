
<div class="card form-card">

    <div class="card-header">
        <h1>Créer un compte</h1>
    </div>

    <div class="card-body">

        <form method="POST" action="/register">

            <div class="form-group">
                <label class="form-label" for="nom">Nom</label>

                <input
                    class="form-control"
                    type="text"
                    id="nom"
                    name="nom"
                    value="<?= htmlspecialchars($data['nom'] ?? '') ?>"
                >

                <?php if (isset($errors['nom'])): ?>
                    <p class="error-message">
                        <?= htmlspecialchars($errors['nom']) ?>
                    </p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label class="form-label" for="prenom">Prénom</label>

                <input
                    class="form-control"
                    type="text"
                    id="prenom"
                    name="prenom"
                    value="<?= htmlspecialchars($data['prenom'] ?? '') ?>"
                >

                <?php if (isset($errors['prenom'])): ?>
                    <p class="error-message">
                        <?= htmlspecialchars($errors['prenom']) ?>
                    </p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email</label>

                <input
                    class="form-control"
                    type="email"
                    id="email"
                    name="email"
                    value="<?= htmlspecialchars($data['email'] ?? '') ?>"
                >

                <?php if (isset($errors['email'])): ?>
                    <p class="error-message">
                        <?= htmlspecialchars($errors['email']) ?>
                    </p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">
                    Mot de passe
                </label>

                <input
                    class="form-control"
                    type="password"
                    id="password"
                    name="password"
                >

                <?php if (isset($errors['password'])): ?>
                    <p class="error-message">
                        <?= htmlspecialchars($errors['password']) ?>
                    </p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">
                    Confirmer le mot de passe
                </label>

                <input
                    class="form-control"
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                >

                <?php if (isset($errors['password_confirmation'])): ?>
                    <p class="error-message">
                        <?= htmlspecialchars($errors['password_confirmation']) ?>
                    </p>
                <?php endif; ?>
            </div>

            <div class="form-actions">
                <button class="btn btn-primary" type="submit">
                    Créer mon compte
                </button>
            </div>

        </form>

    </div>

    <div class="card-footer">
        <span>Déjà un compte ?</span>
        <a class="btn btn-outline" href="/login">
            Se connecter
        </a>
    </div>

</div>
