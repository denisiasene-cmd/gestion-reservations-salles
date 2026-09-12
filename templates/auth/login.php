
<div class="card form-card">

    <div class="card-header">
        <h1>Connexion</h1>
    </div>

    <div class="card-body">

        <form method="POST" action="/login">

            <div class="form-group">
                <label class="form-label" for="email">
                    Email
                </label>

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

            <div class="form-actions">
                <button class="btn btn-primary" type="submit">
                    Se connecter
                </button>
            </div>

        </form>

    </div>

    <div class="card-footer">
        <span>Pas encore de compte ?</span>
        <a class="btn btn-outline" href="/register">
            Créer un compte
        </a>
    </div>

</div>
