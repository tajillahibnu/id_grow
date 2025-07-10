<?php

namespace App\Application\ProdukSerial\UseCase;

use App\Application\ProdukSerial\DTOs\ProdukSerialDTO;
use App\Domain\ProdukSerial\Entities\ProdukSerial;
use App\Domain\ProdukSerial\Repositories\ProdukSerialRepositoryInterface;

class CreateProdukSerial
{
    public function __construct(
        private ProdukSerialRepositoryInterface $repo,
    ) {}

    public function execute(ProdukSerialDTO $dto): ProdukSerial
    {
        $entity = ProdukSerial::fromDTO($dto);
        return $this->repo->storeProdukSerial($entity);
    }
}
