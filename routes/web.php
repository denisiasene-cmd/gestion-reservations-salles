<?php

use App\Controller\SalleController;
use App\Controller\ReservationController;

return function (FastRoute\RouteCollector $routes): void {

    $routes->addRoute('GET', '/salles', [SalleController::class, 'index']);
    $routes->addRoute('GET', '/salles/create', [SalleController::class, 'create']);
    $routes->addRoute('POST', '/salles', [SalleController::class, 'store']);
    $routes->addRoute('GET', '/salles/{id:\d+}', [SalleController::class, 'show']);
    $routes->addRoute('GET', '/salles/{id:\d+}/edit', [SalleController::class, 'edit']);
    $routes->addRoute('POST', '/salles/{id:\d+}', [SalleController::class, 'update']);

    $routes ->addRoute('GET' ,'/api/salles' ,[SalleController::class,'apiindex']);
    $routes->addRoute('GET', '/api/salles/{id:\d+}', [SalleController::class, 'apiShow']);
    $routes->addRoute('GET', '/api/reservations', [ReservationController::class, 'apiIndex']);
    $routes->addRoute('GET', '/api/reservations/{id:\d+}', [ReservationController::class, 'apiShow']);

    $routes->addRoute('GET', '/reservations', [ReservationController::class, 'index']);
    $routes->addRoute('GET', '/reservations/create', [ReservationController::class, 'create']);
    $routes->addRoute('POST', '/reservations', [ReservationController::class, 'store']);
    $routes->addRoute('GET', '/reservations/{id:\d+}', [ReservationController::class, 'show']);
    $routes->addRoute('POST', '/reservations/{id:\d+}/cancel', [ReservationController::class, 'cancel']);
   
};