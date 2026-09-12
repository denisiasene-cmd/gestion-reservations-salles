
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= e_html($title ?? 'Réservation de salles') ?></title>

    <link rel="stylesheet" href="/assets/style.css">
</head>

<body>

<header class="navbar">

    <div class="container navbar-content">

        <a href="/salles" class="logo">
            Réservation de salles
        </a>

        <nav class="nav-links">

            <a href="/salles">
                Salles
            </a>

            <a href="/reservations">
                Réservations
            </a>

            <a href="/reservations/create">
                + Réserver
            </a>

        </nav>

    </div>

</header>


<main>

    <div class="container">

        <?php if (!empty($success)): ?>

            <div class="alert alert-success">
                <?= e_html($success) ?>
            </div>

        <?php endif; ?>


        <?php if (!empty($error)): ?>

            <div class="alert alert-error">
                <?= e_html($error) ?>
            </div>

        <?php endif; ?>


        <?= $content ?? '' ?>

    </div>

</main>


<footer>

    <div class="container">

        <p>
            © <?= date('Y') ?> —
            Système de réservation de salles
        </p>

    </div>

</footer>

</body>
</html>
