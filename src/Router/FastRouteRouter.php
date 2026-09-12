<?php

declare(strict_types=1);

namespace App\Router;

use App\View\ViewInterface;
use FastRoute\Dispatcher;
use Psr\Container\ContainerInterface;

final class FastRouteRouter implements RouterInterface
{
    public function __construct(
        private Dispatcher $dispatcher,
        private ContainerInterface $container,
        private ViewInterface $view
    ) {
    }

    public function dispatch(string $method, string $uri): void
    {
        $routeInfo = $this->dispatcher->dispatch($method, $uri);

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                http_response_code(404);
                $this->view->render('error/404');
                return;

            case Dispatcher::METHOD_NOT_ALLOWED:
                http_response_code(405);
                $allowed = $routeInfo[1];
                header('Allow: ' . implode(', ', $allowed));
                $this->view->render('error/405');
                return;

            case Dispatcher::FOUND:
                [$controllerClass, $action] = $routeInfo[1];
                $controller = $this->container->get($controllerClass);

                $arguments = array_map(
                    static fn (string $value): int|string => ctype_digit($value) ? (int) $value : $value,
                    array_values($routeInfo[2])
                );

                $controller->{$action}(...$arguments);
                return;
        }
    }
}