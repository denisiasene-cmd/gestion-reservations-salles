<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\User;

interface UserRepositoryInterface
{
    public function findByEmail(string $email): ?User;

    public function findById(int $id): ?User;

    public function create(array $data): User;

    public function update(User $user, array $data): User;
}