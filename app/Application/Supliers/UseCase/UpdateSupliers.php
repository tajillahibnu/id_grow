<?php

namespace App\Application\Supliers\UseCase;

use App\Application\Supliers\DTOs\SupliersDTO;
use App\Domain\Supliers\Entities\Supliers;
use App\Domain\Supliers\Repositories\SupliersRepositoryInterface;

class UpdateSupliers
{
    public function __construct(
        private SupliersRepositoryInterface $repo,
    ) {}

    public function execute(SupliersDTO $dto, int $id): Supliers
    {
        $entity = Supliers::fromDTO($dto);
        return $this->repo->updateSupliers($id, $entity);
    }
}
