<?php

declare(strict_types=1);

namespace App\Service\ReservationStrategy;

use App\DTO\CreerReservationDTO;
use App\Repository\SalleRepositoryInterface;
use App\Service\ReservationStrategyInterface;
use App\Exception\SalleIndisponibleException;

class SalleActiveStrategy implements ReservationStrategyInterface
{
    public function __construct(
        private SalleRepositoryInterface $salleRepository
    ) {
    }

    public function verifier(CreerReservationDTO $dto): void
    {
        $salle = $this->salleRepository->findById($dto->salleId);

        if (!$salle->active) {
            throw new SalleIndisponibleException('La salle est inactive.');
        }
    }
}