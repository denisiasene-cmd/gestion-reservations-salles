<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\User;

interface AuthentificationServiceInterface
{
    public function inscrire(array $data): User;

    public function authentifier(string $email, string $password): ?User;

    public function deconnecter(): void;
}