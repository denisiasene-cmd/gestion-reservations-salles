<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Session\SessionManagerInterface;

final class AuthenticationMiddleware
{
    public function __construct(
        private SessionManagerInterface $session
    ) {
    }

    public function handle(string $method, string $uri): bool
    {
        if ($this->isPublicRoute($method, $uri)) {
            return true;
        }

        if ($this->session->get('user_id') === null) {
            header('Location: /login');
            return false;
        }

        return true;
    }

    private function isPublicRoute(string $method, string $uri): bool
    {
        if ($uri === '/') {
            return true;
        }

        if ($uri === '/register') {
            return true;
        }

        if ($uri === '/login') {
            return true;
        }

        return $method === 'POST' && $uri === '/logout';
    }
}
