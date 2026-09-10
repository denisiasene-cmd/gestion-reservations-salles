<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\DTO\CreerReservationDTO;
use App\Exception\SalleIndisponibleException;
use App\Model\Salle;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;
use App\Service\ReservationService;
use PHPUnit\Framework\TestCase;

class ReservationServiceTest extends TestCase
{
    public function testReservationRefuseeEnCasDeConflit(): void
    {
        $salle = new Salle();
        $salle->id = 1;
        $salle->active = true;

        $salleRepository = $this->createMock(SalleRepositoryInterface::class);
        $reservationRepository = $this->createMock(ReservationRepositoryInterface::class);

        $salleRepository
            ->method('findById')
            ->willReturn($salle);

        $reservationRepository
            ->method('findConflict')
            ->willReturn(new \App\Model\Reservation());

        $service = new ReservationService(
            $salleRepository,
            $reservationRepository
        );

        $dto = new CreerReservationDTO(
            1,
            'Denise',
            'denise@test.com',
            'Réunion test',
            new \DateTimeImmutable('+1 day 10:00'),
            new \DateTimeImmutable('+1 day 12:00')
        );

        $this->expectException(SalleIndisponibleException::class);

        $service->creer($dto);
    }
}