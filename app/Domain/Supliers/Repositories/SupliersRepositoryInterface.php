<?php

namespace App\Domain\Supliers\Repositories;

use App\Domain\Supliers\Entities\Supliers;

interface SupliersRepositoryInterface
{
    public function fetchSupliers(string|int $limit = 5, int $offset = 0, string $sort = 'asc'): array;
    public function getSupliersById(int $id): ?Supliers;
    public function storeSupliers(Supliers $params): ?Supliers;
    public function updateSupliers(int $id, Supliers $params): ?Supliers;
    public function deleteSupliers(int $id): ?Supliers;
}
