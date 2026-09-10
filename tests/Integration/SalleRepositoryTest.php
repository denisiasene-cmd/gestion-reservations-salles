<?php

declare(strict_types=1);

namespace Tests\Integration;

use App\Model\Salle;
use App\Repository\EloquentSalleRepository;
use DI\ContainerBuilder;
use PHPUnit\Framework\TestCase;

class SalleRepositoryTest extends TestCase
{
    private EloquentSalleRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $builder = new ContainerBuilder();

        $container = $builder
            ->addDefinitions(dirname(__DIR__, 2) . '/config/container.php')
            ->build();

        $this->repository = $container->get(EloquentSalleRepository::class);
    }

    public function testEnregistrerUneSalle(): void
    {
        $salle = new Salle();

        $salle->nom = 'Salle Integration';
        $salle->batiment = 'B';
        $salle->capacite = 30;
        $salle->type = 'cours';
        $salle->active = true;

        $resultat = $this->repository->save($salle);

        $this->assertNotNull($resultat->id);
        $this->assertSame('Salle Integration', $resultat->nom);

        Salle::destroy($resultat->id);
    }

    public function testRetrouverUneSalleParSonId(): void
    {
        $salle = Salle::create([
            'nom' => 'Salle Recherche',
            'batiment' => 'C',
            'capacite' => 40,
            'type' => 'cours',
            'active' => true,
        ]);

        $resultat = $this->repository->findById($salle->id);

        $this->assertNotNull($resultat);
        $this->assertSame($salle->id, $resultat->id);
        $this->assertSame('Salle Recherche', $resultat->nom);

        Salle::destroy($salle->id);
    }

    public function testFindByIdRetourneNullSiSalleInexistante(): void
    {
        $resultat = $this->repository->findById(999999);

        $this->assertNull($resultat);
    }

    public function testFindAllRetourneLesSalles(): void
    {
        $salle1 = Salle::create([
            'nom' => 'Salle Integration 1',
            'batiment' => 'D',
            'capacite' => 20,
            'type' => 'reunion',
            'active' => true,
        ]);

        $salle2 = Salle::create([
            'nom' => 'Salle Integration 2',
            'batiment' => 'D',
            'capacite' => 50,
            'type' => 'cours',
            'active' => true,
        ]);

        $resultat = $this->repository->findAll();

        $ids = array_map(
            static fn (Salle $salle): int => $salle->id,
            $resultat
        );

        $this->assertContains($salle1->id, $ids);
        $this->assertContains($salle2->id, $ids);

        Salle::destroy([$salle1->id, $salle2->id]);
    }
}
