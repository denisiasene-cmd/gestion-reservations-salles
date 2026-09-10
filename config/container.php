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

    ReservationServiceInterface::class =>
        autowire(ReservationService::class),

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
