<?php

declare(strict_types=1);

namespace Tests\Integration;

use App\Model\Reservation;
use App\Model\Salle;
use App\Repository\EloquentReservationRepository;
use DI\ContainerBuilder;
use PHPUnit\Framework\TestCase;

class ReservationRepositoryTest extends TestCase
{
    private EloquentReservationRepository $repository;
    private Salle $salle;

    protected function setUp(): void
    {
        parent::setUp();

        $builder = new ContainerBuilder();

        $container = $builder
            ->addDefinitions(dirname(__DIR__, 2) . '/config/container.php')
            ->build();

        $this->repository = $container->get(
            EloquentReservationRepository::class
        );

        $this->salle = Salle::create([
            'nom' => 'Salle Test Reservation',
            'batiment' => 'TEST',
            'capacite' => 30,
            'type' => 'cours',
            'active' => true,
        ]);
    }

    protected function tearDown(): void
    {
        Reservation::where('salle_id', $this->salle->id)->delete();
        $this->salle->delete();

        parent::tearDown();
    }

    public function testEnregistrerUneReservation(): void
    {
        $reservation = new Reservation();

        $reservation->salle_id = $this->salle->id;
        $reservation->responsable = 'Denise';
        $reservation->email = 'denise@test.com';
        $reservation->motif = 'Réunion test';
        $reservation->date_debut = new \DateTimeImmutable(
            '2026-10-15 10:00:00'
        );
        $reservation->date_fin = new \DateTimeImmutable(
            '2026-10-15 12:00:00'
        );
        $reservation->statut = 'confirmée';

        $resultat = $this->repository->save($reservation);

        $this->assertNotNull($resultat->id);
        $this->assertSame('Denise', $resultat->responsable);
        $this->assertSame('confirmée', $resultat->statut);
    }

    public function testRetrouverUneReservationParSonId(): void
    {
        $reservation = Reservation::create([
            'salle_id' => $this->salle->id,
            'responsable' => 'Denise',
            'email' => 'denise@test.com',
            'motif' => 'Réunion test',
            'date_debut' => '2026-10-15 10:00:00',
            'date_fin' => '2026-10-15 12:00:00',
            'statut' => 'confirmée',
        ]);

        $resultat = $this->repository->findById($reservation->id);

        $this->assertNotNull($resultat);
        $this->assertSame($reservation->id, $resultat->id);
        $this->assertSame('Denise', $resultat->responsable);
    }

    public function testFindByIdRetourneNullSiReservationInexistante(): void
    {
        $resultat = $this->repository->findById(999999);

        $this->assertNull($resultat);
    }

    public function testFindConflictDetecteUnChevauchement(): void
    {
        Reservation::create([
            'salle_id' => $this->salle->id,
            'responsable' => 'Denise',
            'email' => 'denise@test.com',
            'motif' => 'Réunion test',
            'date_debut' => '2026-10-15 10:00:00',
            'date_fin' => '2026-10-15 12:00:00',
            'statut' => 'confirmée',
        ]);

        $resultat = $this->repository->findConflict(
            $this->salle->id,
            new \DateTimeImmutable('2026-10-15 11:00:00'),
            new \DateTimeImmutable('2026-10-15 13:00:00')
        );

        $this->assertNotNull($resultat);
    }

    public function testFindConflictNeDetectePasReservationVoisine(): void
    {
        Reservation::create([
            'salle_id' => $this->salle->id,
            'responsable' => 'Denise',
            'email' => 'denise@test.com',
            'motif' => 'Réunion test',
            'date_debut' => '2026-10-15 10:00:00',
            'date_fin' => '2026-10-15 12:00:00',
            'statut' => 'confirmée',
        ]);

        $resultat = $this->repository->findConflict(
            $this->salle->id,
            new \DateTimeImmutable('2026-10-15 12:00:00'),
            new \DateTimeImmutable('2026-10-15 14:00:00')
        );

        $this->assertNull($resultat);
    }

    public function testReservationAnnuleeNeBloquePas(): void
    {
        Reservation::create([
            'salle_id' => $this->salle->id,
            'responsable' => 'Denise',
            'email' => 'denise@test.com',
            'motif' => 'Réunion test',
            'date_debut' => '2026-10-15 10:00:00',
            'date_fin' => '2026-10-15 12:00:00',
            'statut' => 'annulée',
        ]);

        $resultat = $this->repository->findConflict(
            $this->salle->id,
            new \DateTimeImmutable('2026-10-15 11:00:00'),
            new \DateTimeImmutable('2026-10-15 13:00:00')
        );

        $this->assertNull($resultat);
    }

    public function testAnnulerUneReservation(): void
    {
        $reservation = Reservation::create([
            'salle_id' => $this->salle->id,
            'responsable' => 'Denise',
            'email' => 'denise@test.com',
            'motif' => 'Réunion test',
            'date_debut' => '2026-10-15 10:00:00',
            'date_fin' => '2026-10-15 12:00:00',
            'statut' => 'confirmée',
        ]);

        $resultat = $this->repository->cancel($reservation);

        $this->assertSame('annulée', $resultat->statut);
    }

    public function testFindAllRetourneLesReservations(): void
    {
        $reservation1 = Reservation::create([
            'salle_id' => $this->salle->id,
            'responsable' => 'Denise',
            'email' => 'denise@test.com',
            'motif' => 'Réunion test 1',
            'date_debut' => '2026-10-15 10:00:00',
            'date_fin' => '2026-10-15 12:00:00',
            'statut' => 'confirmée',
        ]);

        $reservation2 = Reservation::create([
            'salle_id' => $this->salle->id,
            'responsable' => 'Albert',
            'email' => 'albert@test.com',
            'motif' => 'Réunion test 2',
            'date_debut' => '2026-10-16 10:00:00',
            'date_fin' => '2026-10-16 12:00:00',
            'statut' => 'confirmée',
        ]);

        $resultat = $this->repository->findAll();

        $ids = array_map(
            static fn (Reservation $reservation): int => $reservation->id,
            $resultat
        );

        $this->assertContains($reservation1->id, $ids);
        $this->assertContains($reservation2->id, $ids);
    }
}
