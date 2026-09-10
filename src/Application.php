<?php

declare(strict_types=1);

namespace App;

use App\View\View;
use FastRoute\Dispatcher;

final class Application
{
    public function __construct(
        private Dispatcher $dispatcher,
        private View $view,
        private \Closure $controllerResolver
    ) {
    }

    public function run(): void
    {
        try {
            $httpMethod = $_SERVER['REQUEST_METHOD'];

            $uri = $_SERVER['REQUEST_URI'];

            if (false !== $pos = strpos($uri, '?')) {
                $uri = substr($uri, 0, $pos);
            }

            $routeInfo = $this->dispatcher->dispatch(
                $httpMethod,
                $uri
            );

            switch ($routeInfo[0]) {

                case Dispatcher::NOT_FOUND:
                    http_response_code(404);
                    $this->view->render('error/404');
                    return;

                case Dispatcher::METHOD_NOT_ALLOWED:
                    http_response_code(405);
                    echo 'Méthode HTTP non autorisée.';
                    return;

                case Dispatcher::FOUND:
                    $handler = $routeInfo[1];
                    $vars = $routeInfo[2];

                    [$controllerClass, $method] = $handler;

                    $controller = ($this->controllerResolver)(
                        $controllerClass
                    );

                    $arguments = array_map(
                        static fn ($value) =>
                            ctype_digit($value)
                                ? (int) $value
                                : $value,
                        array_values($vars)
                    );

                    $controller->{$method}(...$arguments);

                    return;
            }

        } catch (\Throwable $e) {

            http_response_code(500);

            $this->view->render('error/500');

            return;
        }
    }
}