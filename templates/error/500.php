
<div class="error-page">

    <div class="error-card">

        <div class="error-code">
            500
        </div>

        <h1>
            Une erreur est survenue
        </h1>

        <p>
            Une erreur interne est survenue.
            Veuillez réessayer plus tard.
        </p>

        <?php if (!empty($message)): ?>
            <p class="error-debug">
                <?= e_html($message) ?>
            </p>
        <?php endif; ?>

        <a href="/salles" class="btn btn-primary">
            Retour aux salles
        </a>

    </div>

</div>