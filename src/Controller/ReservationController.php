<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\CreerReservationDTO;
use App\Exception\SalleIndisponibleException;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;
use App\Service\ReservationServiceInterface;
use App\Validation\ReservationValidator;
use App\View\View;

class ReservationController
{
    public function __construct(
        private ReservationRepositoryInterface $reservationRepository,
        private SalleRepositoryInterface $salleRepository,
        private ReservationValidator $validator,
        private ReservationServiceInterface $reservationService,
        private View $view
    ) {
    }

    public function index(): void
    {
        $reservations = $this->reservationRepository->findAll();

        $this->view->render('reservation/index', [
            'reservations' => $reservations
        ]);
    }

    public function show(int $id): void
    {
        $reservation = $this->reservationRepository->findById($id);

        if ($reservation === null) {
            http_response_code(404);

            $this->view->render('error/404');

            return;
        }

        $this->view->render('reservation/show', [
            'reservation' => $reservation
        ]);
    }

    public function create(): void
    {
        $salles = $this->salleRepository->findAll();

        $this->view->render('reservation/form', [
            'salles' => $salles,
            'errors' => [],
            'old' => []
        ]);
    }

    public function store(): void
    {
        $data = $_POST;

        $result = $this->validator->validate($data);

        if (!$result->isValid()) {
            $this->view->render('reservation/form', [
                'salles' => $this->salleRepository->findAll(),
                'errors' => $result->errors(),
                'old' => $data
            ]);

            return;
        }

        $data = $result->data();

        try {
            $dto = new CreerReservationDTO(
                (int) $data['salle_id'],
                $data['responsable'],
                $data['email'],
                $data['motif'],
                new \DateTimeImmutable($data['date_debut']),
                new \DateTimeImmutable($data['date_fin'])
            );

            $this->reservationService->creer($dto);

            header('Location: /reservations');

            exit;

        } catch (\InvalidArgumentException $e) {
            $this->view->render('reservation/form', [
                'salles' => $this->salleRepository->findAll(),
                'errors' => [
                    'date_debut' => [$e->getMessage()]
                ],
                'old' => $data
            ]);

            return;

        } catch (SalleIndisponibleException $e) {
            $this->view->render('reservation/form', [
                'salles' => $this->salleRepository->findAll(),
                'errors' => [
                    'salle_id' => [$e->getMessage()]
                ],
                'old' => $data
            ]);

            return;
        }
    }

    public function cancel(int $id): void
    {
        try {
            $this->reservationService->annuler($id);

            header('Location: /reservations');

            exit;

        } catch (\RuntimeException $e) {
            http_response_code(404);

            $this->view->render('error/404');

            return;
        }
    }
    public function apiIndex(): void
{
    $reservations = $this->reservationRepository->findAll();

    header('Content-Type: application/json; charset=utf-8');

    echo json_encode($reservations);
}
public function apiShow(int $id): void
{
    $reservation = $this->reservationRepository->findById($id);

    if ($reservation === null) {
        http_response_code(404);

        header('Content-Type: application/json; charset=utf-8');

        echo json_encode([
            'message' => 'Réservation introuvable'
        ]);

        return;
    }

    header('Content-Type: application/json; charset=utf-8');

    echo json_encode($reservation);
}
}

