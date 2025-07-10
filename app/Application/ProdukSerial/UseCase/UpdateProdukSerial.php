<?php

namespace App\Application\ProdukSerial\UseCase;

use App\Application\ProdukSerial\DTOs\ProdukSerialDTO;
use App\Domain\ProdukSerial\Entities\ProdukSerial;
use App\Domain\ProdukSerial\Repositories\ProdukSerialRepositoryInterface;

class UpdateProdukSerial
{
    public function __construct(
        private ProdukSerialRepositoryInterface $repo,
    ) {}

    public function execute(ProdukSerialDTO $dto, int $id): ProdukSerial
    {
        $entity = ProdukSerial::fromDTO($dto);
        return $this->repo->updateProdukSerial($id, $entity);
    }
}
