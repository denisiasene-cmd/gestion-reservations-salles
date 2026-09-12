<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\CreerReservationDTO;
use App\Model\Reservation;

interface ReservationServiceInterface
{
    public function creer(
        CreerReservationDTO $dto
    ): Reservation;

    public function annuler(
        int $id
    ): Reservation;

    public function lister(
        int $perPage = 2,
        string $recherche = ''
    ): mixed;

    public function trouver(
        int $id
    ): ?Reservation;

    public function listerToutes(): array;
}