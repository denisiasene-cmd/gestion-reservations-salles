<?php

declare(strict_types=1);

namespace App\Service\ReservationStrategy;

use App\DTO\CreerReservationDTO;
use App\Service\ReservationStrategyInterface;

class DateFutureStrategy implements ReservationStrategyInterface
{
    public function verifier(CreerReservationDTO $dto): void
    {
        if ($dto->dateDebut <= new \DateTimeImmutable()) {
            throw new \InvalidArgumentException(
                'La réservation doit commencer dans le futur.'
            );
        }
    }
}