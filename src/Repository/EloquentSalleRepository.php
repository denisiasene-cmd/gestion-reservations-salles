<?php
declare(strict_types=1);
namespace App\Repository;

use App\Model\Salle;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Pagination\Paginator;

class EloquentSalleRepository implements SalleRepositoryInterface
{
    public function __construct(
        private Manager $database
    ) {
    }

    public function findAll(): array
    {
        return Salle::query()
            ->get()
            ->all();
    }

    public function paginate(int $perPage = 2)
    {
        Paginator::currentPathResolver(
            fn (): string => '/salles'
        );

        Paginator::currentPageResolver(
            fn (): int => max(1, (int) ($_GET['page'] ?? 1))
        );

        return Salle::query()
            ->paginate($perPage);
    }

    public function findById(int $id): ?Salle
    {
        return Salle::find($id);
    }

    public function save(Salle $salle): Salle
    {
        $salle->save();

        return $salle;
    }
    
}