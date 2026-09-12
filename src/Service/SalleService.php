<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Salle;
use App\Repository\SalleRepositoryInterface;

final class SalleService implements SalleServiceInterface
{
    public function __construct(
        private SalleRepositoryInterface $salleRepository
    ) {
    }

    public function lister(int $perPage = 2): mixed
    {
        return $this->salleRepository->paginate($perPage);
    }

    public function listerToutes(): array
    {
        return $this->salleRepository->findAll();
    }

    public function trouver(int $id): ?Salle
    {
        return $this->salleRepository->findById($id);
    }

    public function enregistrer(Salle $salle): Salle
    {
        return $this->salleRepository->save($salle);
    }

    public function modifier(int $id, array $data): ?Salle
    {
        $salle = $this->salleRepository->findById($id);

        if ($salle === null) {
            return null;
        }

        $salle->nom = $data['nom'];
        $salle->batiment = $data['batiment'];
        $salle->capacite = $data['capacite'];
        $salle->type = $data['type'];
        $salle->active = $data['active'];

        return $this->salleRepository->save($salle);
    }
}