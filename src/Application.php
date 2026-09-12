<?php

declare(strict_types=1);

namespace App;

use App\Middleware\AuthenticationMiddleware;
use App\Router\RouterInterface;
use App\View\ViewInterface;

final class Application
{
    public function __construct(
        private RouterInterface $router,
        private ViewInterface $view,
        private AuthenticationMiddleware $authenticationMiddleware
    ) {
    }

    public function run(): void
    {
        try {
            $uri = $_SERVER['REQUEST_URI'] ?? '/';
            $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

            if (false !== $position = strpos($uri, '?')) {
                $uri = substr($uri, 0, $position);
            }

            if (!$this->authenticationMiddleware->handle($method, $uri)) {
                return;
            }

            $this->router->dispatch(
                $method,
                $uri
            );
        } catch (\Throwable $e) {
            http_response_code(500);

            if (($_ENV['APP_DEBUG'] ?? 'false') === 'true') {
                $this->view->render('error/500', [
                    'message' => $e->getMessage(),
                ]);
                return;
            }

            $this->view->render('error/500');
        }
    }
}