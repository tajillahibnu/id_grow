<?php

namespace App\Application\Supliers\UseCase;

use App\Domain\Supliers\Entities\Supliers;
use App\Domain\Supliers\Repositories\SupliersRepositoryInterface;

class DeleteSupliers
{
    public function __construct(
        private SupliersRepositoryInterface $repo
    ) {}

    public function execute(int $id): Supliers
    {
        return $this->repo->deleteSupliers($id);
    }
}
