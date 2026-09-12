<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Salle;

interface SalleServiceInterface
{
    public function lister(int $perPage = 2): mixed;

    public function listerToutes(): array;

    public function trouver(int $id): ?Salle;

    public function enregistrer(Salle $salle): Salle;

    public function modifier(int $id, array $data): ?Salle;
}