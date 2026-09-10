<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\CreerReservationDTO;
use App\Exception\SalleIndisponibleException;
use App\Model\Reservation;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;

class ReservationService implements ReservationServiceInterface
{
    public function __construct(
        private SalleRepositoryInterface $salleRepository,
        private ReservationRepositoryInterface $reservationRepository
    ) {
    }

    public function creer(CreerReservationDTO $dto): Reservation
    {
        $salle = $this->salleRepository->findById($dto->salleId);

        if ($salle === null) {
            throw new \RuntimeException('Salle introuvable.');
        }

      if (!$salle->active) {
    throw new SalleIndisponibleException('La salle est inactive.');
}

        if ($dto->dateDebut >= $dto->dateFin) {
            throw new \InvalidArgumentException(
                'La date de début doit être avant la date de fin.'
            );
        }

        $duree = $dto->dateFin->getTimestamp() - $dto->dateDebut->getTimestamp();

        if ($duree > 4 * 60 * 60) {
            throw new \InvalidArgumentException(
                'La réservation ne peut pas dépasser 4 heures.'
            );
        }

        if ($dto->dateDebut <= new \DateTimeImmutable()) {
            throw new \InvalidArgumentException(
                'La réservation doit commencer dans le futur.'
            );
        }

        $conflit = $this->reservationRepository->findConflict(
            $dto->salleId,
            $dto->dateDebut,
            $dto->dateFin
        );

        if ($conflit !== null) {
            throw new SalleIndisponibleException(
                'La salle est déjà réservée sur cette période.'
            );
        }

        $reservation = new Reservation();

        $reservation->salle_id = $dto->salleId;
        $reservation->responsable = $dto->responsable;
        $reservation->email = $dto->email;
        $reservation->motif = $dto->motif;
        $reservation->date_debut = $dto->dateDebut;
        $reservation->date_fin = $dto->dateFin;
        $reservation->statut = 'confirmée';

        return $this->reservationRepository->save($reservation);
    }

    public function annuler(int $id): Reservation
    {
        $reservation = $this->reservationRepository->findById($id);

        if ($reservation === null) {
            throw new \RuntimeException('Réservation introuvable.');
        }

        return $this->reservationRepository->cancel($reservation);
    }
}

