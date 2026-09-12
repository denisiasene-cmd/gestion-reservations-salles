<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\AuthentificationServiceInterface;
use App\Validation\AuthValidator;
use App\View\ViewInterface;

final class AuthController
{
    public function __construct(
        private AuthentificationServiceInterface $authentificationService,
        private AuthValidator $validator,
        private ViewInterface $view
    ) {
    }

    public function register(): void
    {
        $this->view->render('auth/register');
    }

    public function store(): void
    {
        $data = $_POST;
        $result = $this->validator->validateRegister($data);

        if (!$result->isValid()) {
            $this->view->render('auth/register', [
                'errors' => $result->errors(),
                'data' => $data,
            ]);
            return;
        }

        try {
            $this->authentificationService->inscrire($result->data());
        } catch (\DomainException $e) {
            $this->view->render('auth/register', [
                'errors' => ['email' => $e->getMessage()],
                'data' => $data,
            ]);
            return;
        }

        header('Location: /login');
        exit;
    }

    public function login(): void
    {
        $this->view->render('auth/login');
    }

    public function authenticate(): void
    {
        $data = $_POST;
        $result = $this->validator->validateLogin($data);

        if (!$result->isValid()) {
            $this->view->render('auth/login', [
                'errors' => $result->errors(),
                'data' => $data,
            ]);
            return;
        }

        $user = $this->authentificationService->authentifier(
            $data['email'],
            $data['password']
        );

        if ($user === null) {
            $this->view->render('auth/login', [
                'errors' => ['email' => 'Email ou mot de passe incorrect.'],
                'data' => $data,
            ]);
            return;
        }

        header('Location: /salles');
        exit;
    }

    public function logout(): void
    {
        $this->authentificationService->deconnecter();
        header('Location: /login');
        exit;
    }
}