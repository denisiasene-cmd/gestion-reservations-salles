<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\CreerReservationDTO;

interface ReservationStrategyInterface
{
    public function verifier(CreerReservationDTO $dto): void;
}