<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Reservation;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Pagination\Paginator;

class EloquentReservationRepository implements ReservationRepositoryInterface
{
    public function __construct(
        private Manager $database
    ) {
    }

    public function findAll(): array
    {
        return Reservation::query()
            ->get()
            ->all();
    }

    public function paginate(
        int $perPage = 2,
        string $recherche = ''
    ): mixed {
        Paginator::currentPathResolver(
            fn (): string => '/reservations'
        );

        Paginator::currentPageResolver(
            fn (): int => max(
                1,
                (int) ($_GET['page'] ?? 1)
            )
        );

        $query = Reservation::query()
            ->with('salle');

        /*
         * Recherche dans :
         * - le responsable
         * - le motif
         */
        if ($recherche !== '') {

    $query->where(function ($q) use ($recherche): void {

        $q->where(
            'responsable',
            'like',
            '%' . $recherche . '%'
        )->orWhere(
            'motif',
            'like',
            '%' . $recherche . '%'
        )->orWhereHas(
            'salle',
            function ($salleQuery) use ($recherche): void {

                $salleQuery->where(
                    'nom',
                    'like',
                    '%' . $recherche . '%'
                );

            }
        );

    });

}

        $paginator = $query
            ->orderBy('date_debut', 'desc')
            ->paginate($perPage);

        /*
         * Conserver la recherche lorsqu'on change de page.
         */
        return $paginator->appends([
            'recherche' => $recherche,
        ]);
    }

    public function findById(int $id): ?Reservation
    {
        return Reservation::find($id);
    }

    public function findConflict(
        int $salleId,
        \DateTimeImmutable $dateDebut,
        \DateTimeImmutable $dateFin
    ): ?Reservation {
        return Reservation::query()
            ->where('salle_id', $salleId)
            ->where('statut', 'confirmée')
            ->where(
                'date_debut',
                '<',
                $dateFin->format('Y-m-d H:i:s')
            )
            ->where(
                'date_fin',
                '>',
                $dateDebut->format('Y-m-d H:i:s')
            )
            ->first();
    }

    public function save(Reservation $reservation): Reservation
    {
        $reservation->save();

        return $reservation;
    }

    public function cancel(Reservation $reservation): Reservation
    {
        $reservation->statut = 'annulée';
        $reservation->save();

        return $reservation;
    }
}