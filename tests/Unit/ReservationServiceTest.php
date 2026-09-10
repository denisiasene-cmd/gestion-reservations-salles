<?php

declare(strict_types=1);
namespace Tests\Unit;

use App\DTO\CreerReservationDTO;
use App\Exception\SalleIndisponibleException;
use App\Model\Reservation;
use App\Model\Salle;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;
use App\Service\ReservationService;
use Illuminate\Database\Capsule\Manager as Capsule;
use PHPUnit\Framework\TestCase;

class ReservationServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $capsule = new Capsule();

        $capsule->addConnection([
            'driver' => 'sqlite',
            'database' => ':memory:',
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    public function testReservationValide(): void
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
            ->willReturn(null);

        $reservationRepository
            ->method('save')
            ->willReturnCallback(
                fn (Reservation $reservation): Reservation => $reservation
            );

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

        $reservation = $service->creer($dto);

        $this->assertInstanceOf(Reservation::class, $reservation);
    }

    public function testReservationRefuseeSiSalleInexistante(): void
    {
        $salleRepository = $this->createMock(SalleRepositoryInterface::class);
        $reservationRepository = $this->createMock(ReservationRepositoryInterface::class);

        $salleRepository
            ->method('findById')
            ->willReturn(null);

        $service = new ReservationService(
            $salleRepository,
            $reservationRepository
        );

        $dto = new CreerReservationDTO(
            99,
            'Denise',
            'denise@test.com',
            'Réunion test',
            new \DateTimeImmutable('+1 day 10:00'),
            new \DateTimeImmutable('+1 day 12:00')
        );

        $this->expectException(\RuntimeException::class);

        $service->creer($dto);
    }

    public function testReservationRefuseeSiSalleInactive(): void
    {
        $salle = new Salle();
        $salle->id = 1;
        $salle->active = false;

        $salleRepository = $this->createMock(SalleRepositoryInterface::class);
        $reservationRepository = $this->createMock(ReservationRepositoryInterface::class);

        $salleRepository
            ->method('findById')
            ->willReturn($salle);

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

    public function testReservationRefuseeSiDateFinAvantDebut(): void
    {
        $salle = new Salle();
        $salle->id = 1;
        $salle->active = true;

        $salleRepository = $this->createMock(SalleRepositoryInterface::class);
        $reservationRepository = $this->createMock(ReservationRepositoryInterface::class);

        $salleRepository
            ->method('findById')
            ->willReturn($salle);

        $service = new ReservationService(
            $salleRepository,
            $reservationRepository
        );

        $dto = new CreerReservationDTO(
            1,
            'Denise',
            'denise@test.com',
            'Réunion test',
            new \DateTimeImmutable('+1 day 14:00'),
            new \DateTimeImmutable('+1 day 12:00')
        );

        $this->expectException(\InvalidArgumentException::class);

        $service->creer($dto);
    }

    public function testReservationRefuseeSiDureeSuperieureA4Heures(): void
    {
        $salle = new Salle();
        $salle->id = 1;
        $salle->active = true;

        $salleRepository = $this->createMock(SalleRepositoryInterface::class);
        $reservationRepository = $this->createMock(ReservationRepositoryInterface::class);

        $salleRepository
            ->method('findById')
            ->willReturn($salle);

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
            new \DateTimeImmutable('+1 day 15:00')
        );

        $this->expectException(\InvalidArgumentException::class);

        $service->creer($dto);
    }

    public function testReservationRefuseeSiDateDansLePasse(): void
    {
        $salle = new Salle();
        $salle->id = 1;
        $salle->active = true;

        $salleRepository = $this->createMock(SalleRepositoryInterface::class);
        $reservationRepository = $this->createMock(ReservationRepositoryInterface::class);

        $salleRepository
            ->method('findById')
            ->willReturn($salle);

        $service = new ReservationService(
            $salleRepository,
            $reservationRepository
        );

        $dto = new CreerReservationDTO(
            1,
            'Denise',
            'denise@test.com',
            'Réunion test',
            new \DateTimeImmutable('-1 day 10:00'),
            new \DateTimeImmutable('-1 day 12:00')
        );

        $this->expectException(\InvalidArgumentException::class);

        $service->creer($dto);
    }

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
            ->willReturn(new Reservation());

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

    public function testReservationVoisineSansChevauchement(): void
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
            ->willReturn(null);

        $reservationRepository
            ->method('save')
            ->willReturnCallback(
                fn (Reservation $reservation): Reservation => $reservation
            );

        $service = new ReservationService(
            $salleRepository,
            $reservationRepository
        );

        $dto = new CreerReservationDTO(
            1,
            'Denise',
            'denise@test.com',
            'Réunion test',
            new \DateTimeImmutable('+1 day 12:00'),
            new \DateTimeImmutable('+1 day 14:00')
        );

        $reservation = $service->creer($dto);

        $this->assertInstanceOf(Reservation::class, $reservation);
    }
}

