<?php

declare(strict_types=1);

namespace App\Service\ReservationStrategy;

use App\DTO\CreerReservationDTO;
use App\Service\ReservationStrategyInterface;

class DatesValidesStrategy implements ReservationStrategyInterface
{
    public function verifier(CreerReservationDTO $dto): void
    {
        if ($dto->dateDebut >= $dto->dateFin) {
            throw new \InvalidArgumentException(
                'La date de début doit être avant la date de fin.'
            );
        }
    }
}