<?php

declare(strict_types=1);

use App\Application;
use App\Controller\AuthController;
use App\Controller\ReservationController;
use App\Controller\SalleController;
use App\Middleware\AuthenticationMiddleware;
use App\Repository\EloquentReservationRepository;
use App\Repository\EloquentSalleRepository;
use App\Repository\EloquentUserRepository;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Router\FastRouteRouter;
use App\Router\RouterInterface;
use App\Service\AuthentificationService;
use App\Service\AuthentificationServiceInterface;
use App\Service\ReservationService;
use App\Service\ReservationServiceInterface;
use App\Service\ReservationStrategy\DateFutureStrategy;
use App\Service\ReservationStrategy\DatesValidesStrategy;
use App\Service\ReservationStrategy\DureeMaxStrategy;
use App\Service\ReservationStrategy\PasDeConflitStrategy;
use App\Service\ReservationStrategy\SalleActiveStrategy;
use App\Service\ReservationStrategy\SalleExisteStrategy;
use App\Service\ReservationStrategyInterface;
use App\Service\SalleService;
use App\Service\SalleServiceInterface;
use App\Session\SessionManager;
use App\Session\SessionManagerInterface;
use App\Validation\AuthValidator;
use App\Validation\ReservationValidator;
use App\Validation\SalleValidator;
use App\View\HtmlView;
use App\View\JsonView;
use App\View\ViewInterface;
use FastRoute\Dispatcher;
use Illuminate\Database\Capsule\Manager;
use Psr\Container\ContainerInterface;
use function DI\autowire;
use function DI\factory;
use function DI\get;
use function FastRoute\simpleDispatcher;

\Dotenv\Dotenv::createImmutable(dirname(__DIR__))->safeLoad();


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
        'options' => [
            \PDO::MYSQL_ATTR_SSL_CA => dirname(__DIR__) . '/config/certs/ca.pem',
            \PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => true,
        ],
    ]);

    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule;
}),

    SalleRepositoryInterface::class => autowire(EloquentSalleRepository::class),
    ReservationRepositoryInterface::class => autowire(EloquentReservationRepository::class),
    UserRepositoryInterface::class => autowire(EloquentUserRepository::class),

    SalleValidator::class => autowire(),
    ReservationValidator::class => autowire(),
    AuthValidator::class => autowire(),

    SalleExisteStrategy::class => autowire(),
    SalleActiveStrategy::class => autowire(),
    DatesValidesStrategy::class => autowire(),
    DureeMaxStrategy::class => autowire(),
    DateFutureStrategy::class => autowire(),
    PasDeConflitStrategy::class => autowire(),

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

    // IMPORTANT : on indique à PHP-DI comment remplir $strategies
    ReservationServiceInterface::class => autowire(ReservationService::class)
        ->constructorParameter(
            'strategies',
            get(ReservationStrategyInterface::class)
        ),

    SalleServiceInterface::class => autowire(SalleService::class),
    AuthentificationServiceInterface::class => autowire(AuthentificationService::class),
    SessionManagerInterface::class => autowire(SessionManager::class),

    AuthenticationMiddleware::class => autowire(),

    ViewInterface::class => factory(function (): ViewInterface {
        $driver = strtolower($_ENV['VIEW_DRIVER'] ?? 'html');
        $templatesPath = dirname(__DIR__) . '/templates';

        return $driver === 'json'
            ? new JsonView()
            : new HtmlView($templatesPath);
    }),

    JsonView::class => autowire(),

    Dispatcher::class => factory(function (): Dispatcher {
        $routes = require dirname(__DIR__) . '/routes/web.php';

        return simpleDispatcher($routes);
    }),

    RouterInterface::class => factory(
        function (ContainerInterface $container): RouterInterface {
            return new FastRouteRouter(
                $container->get(Dispatcher::class),
                $container,
                $container->get(ViewInterface::class)
            );
        }
    ),

    SalleController::class => autowire(),
    ReservationController::class => autowire(),
    AuthController::class => autowire(),

    Application::class => autowire(),
];
