<?php

declare(strict_types=1);

use App\Application;
use App\Controller\ReservationController;
use App\Controller\SalleController;
use App\Repository\EloquentReservationRepository;
use App\Repository\EloquentSalleRepository;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;
use App\Service\ReservationService;
use App\Service\ReservationServiceInterface;
use App\Service\ReservationStrategy\DateFutureStrategy;
use App\Service\ReservationStrategy\DatesValidesStrategy;
use App\Service\ReservationStrategy\DureeMaxStrategy;
use App\Service\ReservationStrategy\PasDeConflitStrategy;
use App\Service\ReservationStrategy\SalleActiveStrategy;
use App\Service\ReservationStrategy\SalleExisteStrategy;
use App\Service\ReservationStrategyInterface;
use App\Validation\ReservationValidator;
use App\Validation\SalleValidator;
use App\View\View;
use FastRoute\Dispatcher;
use Illuminate\Database\Capsule\Manager;
use Psr\Container\ContainerInterface;
use function DI\autowire;
use function DI\factory;
use function FastRoute\simpleDispatcher;

\Dotenv\Dotenv::createImmutable(dirname(__DIR__))->load();

return [

    Manager::class => factory(function (): Manager {
        $capsule = new Manager();

        $capsule->addConnection([
            'driver' => $_ENV['DB_DRIVER'],
            'host' => $_ENV['DB_HOST'],
            'port' => $_ENV['DB_PORT'],
            'database' => $_ENV['DB_DATABASE'],
            'username' => $_ENV['DB_USERNAME'],
            'password' => $_ENV['DB_PASSWORD'],
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        return $capsule;
    }),

    SalleRepositoryInterface::class =>
        autowire(EloquentSalleRepository::class),

    ReservationRepositoryInterface::class =>
        autowire(EloquentReservationRepository::class),

    SalleValidator::class =>
        autowire(),

    ReservationValidator::class =>
        autowire(),

    SalleExisteStrategy::class =>
        autowire(),

    SalleActiveStrategy::class =>
        autowire(),

    DatesValidesStrategy::class =>
        autowire(),

    DureeMaxStrategy::class =>
        autowire(),

    DateFutureStrategy::class =>
        autowire(),

    PasDeConflitStrategy::class =>
        autowire(),

    ReservationStrategyInterface::class => factory(
        function (ContainerInterface $container): array {
            return [
                $container->get(SalleExisteStrategy::class),
                $container->get(SalleActiveStrategy::class),
                $container->get(DatesValidesStrategy::class),
                $container->get(DureeMaxStrategy::class),
                $container->get(DateFutureStrategy::class),
                $container->get(PasDeConflitStrategy::class),
            ];
        }
    ),

    ReservationServiceInterface::class => factory(
        function (ContainerInterface $container): ReservationService {
            return new ReservationService(
                $container->get(ReservationRepositoryInterface::class),
                $container->get(ReservationStrategyInterface::class)
            );
        }
    ),

    View::class => factory(function (): View {
        return new View(
            dirname(__DIR__) . '/templates'
        );
    }),

    Dispatcher::class => factory(function (): Dispatcher {
        $routes = require dirname(__DIR__) . '/routes/web.php';

        return simpleDispatcher($routes);
    }),

    SalleController::class =>
        autowire(),

    ReservationController::class =>
        autowire(),

    Application::class => factory(
        function (ContainerInterface $container): Application {
            return new Application(
                $container->get(Dispatcher::class),
                $container->get(View::class),
                function (string $controllerClass) use ($container): object {
                    return $container->get($controllerClass);
                }
            );
        }
    ),
];