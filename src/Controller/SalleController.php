<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\CreerSalleDTO;
use App\Model\Salle;
use App\Repository\SalleRepositoryInterface;

use App\Validation\SalleValidator;
use App\View\View;

class SalleController
{
    public function __construct(
        private SalleRepositoryInterface $salleRepository,
        private SalleValidator $validator,
        private View $view,
       
    ) {
    }

    public function index(): void
    {
        $salles = $this->salleRepository->findAll();

        $this->view->render('salle/index', [
            'salles' => $salles
        ]);
    }

    public function show(int $id): void
    {
        $salle = $this->salleRepository->findById($id);

        if ($salle === null) {
            http_response_code(404);

            $this->view->render('error/404');

            return;
        }

        $this->view->render('salle/show', [
            'salle' => $salle
        ]);
    }

    public function create(): void
    {
        $this->view->render('salle/form', [
            'errors' => [],
            'old' => []
        ]);
    }

    public function store(): void
    {
        $data = $_POST;

        if (isset($data['capacite'])) {
            $data['capacite'] = (int) $data['capacite'];
        }

        $data['active'] = isset($data['active']);

        $result = $this->validator->validate($data);

        if (!$result->isValid()) {
            $this->view->render('salle/form', [
                'errors' => $result->errors(),
                'old' => $data
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

        $this->salleRepository->save($salle);

      

        header('Location: /salles');

        exit;
    }

    public function edit(int $id): void
    {
        $salle = $this->salleRepository->findById($id);

        if ($salle === null) {
            http_response_code(404);

            $this->view->render('error/404');

            return;
        }

        $this->view->render('salle/form', [
            'salle' => $salle,
            'errors' => [],
            'old' => []
        ]);
    }

    public function update(int $id): void
    {
        // La modification sera ajoutée avec le routage.
    }
}
