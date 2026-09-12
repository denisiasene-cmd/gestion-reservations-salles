<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\CreerSalleDTO;
use App\Model\Salle;
use App\Service\SalleServiceInterface;
use App\Validation\SalleValidator;
use App\View\JsonView;
use App\View\ViewInterface;

final class SalleController
{
    public function __construct(
        private SalleServiceInterface $salleService,
        private SalleValidator $validator,
        private ViewInterface $view,
        private JsonView $jsonView
    ) {
    }

    public function index(): void
    {
        $this->view->render('salle/index', [
            'salles' => $this->salleService->lister(2),
        ]);
    }

    public function apiIndex(): void
    {
        $this->jsonView->render('salles', [
            'data' => $this->salleService->listerToutes(),
        ]);
    }

    public function show(int $id): void
    {
        $salle = $this->salleService->trouver($id);

        if ($salle === null) {
            http_response_code(404);
            $this->view->render('error/404');
            return;
        }

        $this->view->render('salle/show', ['salle' => $salle]);
    }

    public function apiShow(int $id): void
    {
        $salle = $this->salleService->trouver($id);

        if ($salle === null) {
            http_response_code(404);
            $this->jsonView->render('salle', [
                'message' => 'Salle introuvable',
            ]);
            return;
        }

        $this->jsonView->render('salle', ['data' => $salle]);
    }

    public function create(): void
    {
        $this->view->render('salle/form', [
            'errors' => [],
            'old' => [],
        ]);
    }

    public function store(): void
    {
        $data = $_POST;
        $data['capacite'] = isset($data['capacite']) ? (int) $data['capacite'] : null;
        $data['active'] = isset($data['active']);

        $result = $this->validator->validate($data);

        if (!$result->isValid()) {
            $this->view->render('salle/form', [
                'errors' => $result->errors(),
                'old' => $data,
            ]);
            return;
        }

        $data = $result->data();
        $dto = new CreerSalleDTO(
            $data['nom'],
            $data['batiment'],
            $data['capacite'],
            $data['type'],
            $data['active']
        );

        $salle = new Salle();
        $salle->nom = $dto->nom;
        $salle->batiment = $dto->batiment;
        $salle->capacite = $dto->capacite;
        $salle->type = $dto->type;
        $salle->active = $dto->active;

        $this->salleService->enregistrer($salle);

        header('Location: /salles');
        exit;
    }

    public function edit(int $id): void
    {
        $salle = $this->salleService->trouver($id);

        if ($salle === null) {
            http_response_code(404);
            $this->view->render('error/404');
            return;
        }

        $this->view->render('salle/form', [
            'salle' => $salle,
            'errors' => [],
            'old' => [],
        ]);
    }

    public function update(int $id): void
    {
        $data = $_POST;
        $data['capacite'] = isset($data['capacite']) ? (int) $data['capacite'] : null;
        $data['active'] = isset($data['active']);

        $result = $this->validator->validate($data);

        if (!$result->isValid()) {
            $salle = $this->salleService->trouver($id);
            $this->view->render('salle/form', [
                'salle' => $salle,
                'errors' => $result->errors(),
                'old' => $data,
            ]);
            return;
        }

        if ($this->salleService->modifier($id, $result->data()) === null) {
            http_response_code(404);
            $this->view->render('error/404');
            return;
        }

        header('Location: /salles');
        exit;
    }
}