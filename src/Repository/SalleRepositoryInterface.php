<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Salle;

interface SalleRepositoryInterface
{
    public function findAll(): array;

    public function paginate(int $perPage = 2);

    public function findById(int $id): ?Salle;

    public function save(Salle $salle): Salle;
}