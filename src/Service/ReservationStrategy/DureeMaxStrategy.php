<?php

declare(strict_types=1);

namespace App\Service\ReservationStrategy;

use App\DTO\CreerReservationDTO;
use App\Service\ReservationStrategyInterface;

class DureeMaxStrategy implements ReservationStrategyInterface
{
    public function verifier(CreerReservationDTO $dto): void
    {
        $duree = $dto->dateFin->getTimestamp()
            - $dto->dateDebut->getTimestamp();

        if ($duree > 4 * 60 * 60) {
            throw new \InvalidArgumentException(
                'La réservation ne peut pas dépasser 4 heures.'
            );
        }
    }
}