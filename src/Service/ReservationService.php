<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\CreerReservationDTO;
use App\Model\Reservation;
use App\Repository\ReservationRepositoryInterface;

class ReservationService implements ReservationServiceInterface
{
    public function __construct(
        private ReservationRepositoryInterface $reservationRepository,
        private array $strategies
    ) {
    }

    public function creer(
        CreerReservationDTO $dto
    ): Reservation {
        foreach ($this->strategies as $strategy) {
            $strategy->verifier($dto);
        }

        $reservation = new Reservation();

        $reservation->salle_id = $dto->salleId;
        $reservation->responsable = $dto->responsable;
        $reservation->email = $dto->email;
        $reservation->motif = $dto->motif;
        $reservation->date_debut = $dto->dateDebut;
        $reservation->date_fin = $dto->dateFin;
        $reservation->statut = 'confirmée';

        return $this->reservationRepository->save(
            $reservation
        );
    }

    public function lister(
        int $perPage = 2,
        string $recherche = ''
    ): mixed {
        return $this->reservationRepository->paginate(
            $perPage,
            $recherche
        );
    }

    public function trouver(
        int $id
    ): ?Reservation {
        return $this->reservationRepository->findById($id);
    }

    public function listerToutes(): array
    {
        return $this->reservationRepository->findAll();
    }

    public function annuler(
        int $id
    ): Reservation {
        $reservation = $this->reservationRepository->findById($id);

        if ($reservation === null) {
            throw new \RuntimeException(
                'Réservation introuvable.'
            );
        }

        return $this->reservationRepository->cancel(
            $reservation
        );
    }
}