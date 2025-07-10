<?php

namespace App\Application\Supliers\UseCase;

use App\Domain\Supliers\Entities\Supliers;
use App\Domain\Supliers\Repositories\SupliersRepositoryInterface;
use Exception;

class GetSupliersById
{
    public function __construct(
        private SupliersRepositoryInterface $repo
    ) {}

    public function execute(int $id): Supliers
    {
        $item = $this->repo->getSupliersById($id);

        if (!$item) {
            throw new Exception("Data tidak ditemukan");
        }
        return $item;
    }
}
