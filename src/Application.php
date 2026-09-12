<?php

declare(strict_types=1);

namespace App;

use App\Router\RouterInterface;
use App\View\ViewInterface;

final class Application
{
    public function __construct(
        private RouterInterface $router,
        private ViewInterface $view
    ) {
    }

    public function run(): void
    {
        try {
            $uri = $_SERVER['REQUEST_URI'] ?? '/';

            if (false !== $position = strpos($uri, '?')) {
                $uri = substr($uri, 0, $position);
            }

            $this->router->dispatch(
                $_SERVER['REQUEST_METHOD'] ?? 'GET',
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