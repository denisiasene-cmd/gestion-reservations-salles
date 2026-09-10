<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

use FastRoute\Dispatcher;
use function FastRoute\simpleDispatcher;

// Charger les variables d'environnement
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

// Initialiser la base de données
require_once dirname(__DIR__) . '/config/database.php';

// Charger le container
$container = require dirname(__DIR__) . '/config/container.php';

// Charger les routes
$routes = require dirname(__DIR__) . '/routes/web.php';

// Créer le dispatcher FastRoute
$dispatcher = simpleDispatcher($routes);

// Récupérer la méthode HTTP et l'URI
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}

// Dispatcher la requête
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {

    case Dispatcher::NOT_FOUND:
        http_response_code(404);

        $view = $container->get(App\View\View::class);
        $view->render('error/404');

        break;

    case Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);

        echo 'Méthode HTTP non autorisée.';
        break;

   case Dispatcher::FOUND:

    $handler = $routeInfo[1];
    $vars = $routeInfo[2];

    [$controllerClass, $method] = $handler;

    $controller = $container->get($controllerClass);

    $controller->{$method}(
        ...array_map(
            static fn ($value) => ctype_digit($value) ? (int) $value : $value,
            array_values($vars)
        )
    );

    break;
}

