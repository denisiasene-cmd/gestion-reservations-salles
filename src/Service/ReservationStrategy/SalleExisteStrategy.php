<?php

declare(strict_types=1);

namespace App\Service\ReservationStrategy;

use App\DTO\CreerReservationDTO;
use App\Exception\SalleIntrouvableException;
use App\Repository\SalleRepositoryInterface;
use App\Service\ReservationStrategyInterface;

class SalleExisteStrategy implements ReservationStrategyInterface
{
    public function __construct(
        private SalleRepositoryInterface $salleRepository
    ) {
    }

    public function verifier(CreerReservationDTO $dto): void
    {
        $salle = $this->salleRepository->findById($dto->salleId);

        if ($salle === null) {
            throw new SalleIntrouvableException('Salle introuvable.');
        }
    }
}