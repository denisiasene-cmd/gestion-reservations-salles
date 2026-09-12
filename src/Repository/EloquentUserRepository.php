<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\User;

final class EloquentUserRepository implements UserRepositoryInterface
{
    public function findByEmail(string $email): ?User
    {
        return User::query()->where('email', $email)->first();
    }

    public function findById(int $id): ?User
    {
        return User::query()->find($id);
    }

    public function create(array $data): User
    {
        return User::query()->create($data);
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);

        return $user;
    }
}