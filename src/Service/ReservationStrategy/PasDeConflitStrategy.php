<?php

declare(strict_types=1);

namespace App\Service\ReservationStrategy;

use App\DTO\CreerReservationDTO;
use App\Repository\ReservationRepositoryInterface;
use App\Service\ReservationStrategyInterface;
use App\Exception\SalleIndisponibleException;

class PasDeConflitStrategy implements ReservationStrategyInterface
{
    public function __construct(
        private ReservationRepositoryInterface $reservationRepository
    ) {
    }

    public function verifier(CreerReservationDTO $dto): void
    {
        $conflit = $this->reservationRepository->findConflict(
            $dto->salleId,
            $dto->dateDebut,
            $dto->dateFin
        );

        if ($conflit !== null) {
            throw new SalleIndisponibleException(
                'La salle est déjà réservée sur cette période.'
            );
        }
    }
}