<?php

namespace App\Application\Supliers\UseCase;

use App\Application\Supliers\DTOs\SupliersDTO;
use App\Domain\Supliers\Entities\Supliers;
use App\Domain\Supliers\Repositories\SupliersRepositoryInterface;

class CreateSupliers
{
    public function __construct(
        private SupliersRepositoryInterface $repo,
    ) {}

    public function execute(SupliersDTO $dto): Supliers
    {
        $entity = Supliers::fromDTO($dto);
        return $this->repo->storeSupliers($entity);
    }
}
