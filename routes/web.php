<?php

use App\Controller\AuthController;
use App\Controller\SalleController;
use App\Controller\ReservationController;

return function (FastRoute\RouteCollector $routes): void {

    // Authentification
    $routes->addRoute('GET', '/register', [AuthController::class, 'register']);
    $routes->addRoute('POST', '/register', [AuthController::class, 'store']);
    $routes->addRoute('GET', '/login', [AuthController::class, 'login']);
    $routes->addRoute('POST', '/login', [AuthController::class, 'authenticate']);
    $routes->addRoute('POST', '/logout', [AuthController::class, 'logout']);

    // Salles
    $routes->addRoute('GET', '/salles', [SalleController::class, 'index']);
    $routes->addRoute('GET', '/salles/create', [SalleController::class, 'create']);
    $routes->addRoute('POST', '/salles', [SalleController::class, 'store']);
    $routes->addRoute('GET', '/salles/{id:\d+}', [SalleController::class, 'show']);
    $routes->addRoute('GET', '/salles/{id:\d+}/edit', [SalleController::class, 'edit']);
    $routes->addRoute('POST', '/salles/{id:\d+}', [SalleController::class, 'update']);

    // API
    $routes->addRoute('GET', '/api/salles', [SalleController::class, 'apiIndex']);
    $routes->addRoute('GET', '/api/salles/{id:\d+}', [SalleController::class, 'apiShow']);
    $routes->addRoute('GET', '/api/reservations', [ReservationController::class, 'apiIndex']);
    $routes->addRoute('GET', '/api/reservations/{id:\d+}', [ReservationController::class, 'apiShow']);

    // Réservations
    $routes->addRoute('GET', '/reservations', [ReservationController::class, 'index']);
    $routes->addRoute('GET', '/reservations/create', [ReservationController::class, 'create']);
    $routes->addRoute('POST', '/reservations', [ReservationController::class, 'store']);
    $routes->addRoute('GET', '/reservations/{id:\d+}', [ReservationController::class, 'show']);
    $routes->addRoute('POST', '/reservations/{id:\d+}/cancel', [ReservationController::class, 'cancel']);
};