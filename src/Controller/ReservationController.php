<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\CreerReservationDTO;
use App\Exception\SalleIndisponibleException;
use App\Exception\SalleIntrouvableException;
use App\Service\ReservationServiceInterface;
use App\Service\SalleServiceInterface;
use App\Session\SessionManagerInterface;
use App\Validation\ReservationValidator;
use App\View\JsonView;
use App\View\ViewInterface;

final class ReservationController
{
    public function __construct(
        private ReservationServiceInterface $reservationService,
        private SalleServiceInterface $salleService,
        private ReservationValidator $validator,
        private SessionManagerInterface $session,
        private ViewInterface $view,
        private JsonView $jsonView
    ) {
    }

    public function index(): void
    {
        $success = $this->session->get('success');

        $this->session->remove('success');

        $recherche = trim(
            (string) ($_GET['recherche'] ?? '')
        );

        $this->view->render('reservation/index', [
            'reservations' => $this->reservationService->lister(
                2,
                $recherche
            ),
            'recherche' => $recherche,
            'success' => $success,
        ]);
    }

    public function show(int $id): void
    {
        $reservation = $this->reservationService->trouver($id);

        if ($reservation === null) {
            http_response_code(404);

            $this->view->render('error/404');

            return;
        }

        $this->view->render('reservation/show', [
            'reservation' => $reservation,
        ]);
    }

    public function create(): void
    {
        $this->view->render('reservation/form', [
            'salles' => $this->salleService->listerToutes(),
            'errors' => [],
            'old' => [],
        ]);
    }

    public function store(): void
    {
        $data = $_POST;

        $data['salle_id'] = isset($data['salle_id'])
            ? (int) $data['salle_id']
            : null;

        $result = $this->validator->validate($data);

        if (!$result->isValid()) {
            $this->view->render('reservation/form', [
                'salles' => $this->salleService->listerToutes(),
                'errors' => $result->errors(),
                'old' => $data,
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
                new \DateTimeImmutable(
                    $data['date_debut']
                ),
                new \DateTimeImmutable(
                    $data['date_fin']
                )
            );

            $this->reservationService->creer($dto);

            $this->session->set(
                'success',
                'Réservation créée avec succès.'
            );

            header('Location: /reservations');

            exit;
        } catch (
            \InvalidArgumentException |
            SalleIndisponibleException |
            SalleIntrouvableException $e
        ) {
            $champ = $e instanceof \InvalidArgumentException
                ? 'date_debut'
                : 'salle_id';

            $this->view->render('reservation/form', [
                'salles' => $this->salleService->listerToutes(),
                'errors' => [
                    $champ => [
                        $e->getMessage(),
                    ],
                ],
                'old' => $data,
            ]);
        }
    }

    public function cancel(int $id): void
    {
        try {
            $this->reservationService->annuler($id);

            $this->session->set(
                'success',
                'Réservation annulée avec succès.'
            );

            header('Location: /reservations');

            exit;
        } catch (\RuntimeException $e) {
            http_response_code(404);

            $this->view->render('error/404');
        }
    }

    public function apiIndex(): void
    {
        $this->jsonView->render('reservations', [
            'data' => $this->reservationService->listerToutes(),
        ]);
    }

    public function apiShow(int $id): void
    {
        $reservation = $this->reservationService->trouver($id);

        if ($reservation === null) {
            http_response_code(404);

            $this->jsonView->render('reservation', [
                'message' => 'Réservation introuvable',
            ]);

            return;
        }

        $this->jsonView->render('reservation', [
            'data' => $reservation,
        ]);
    }
}