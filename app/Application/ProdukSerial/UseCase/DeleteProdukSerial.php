<?php

namespace App\Application\ProdukSerial\UseCase;

use App\Domain\ProdukSerial\Entities\ProdukSerial;
use App\Domain\ProdukSerial\Repositories\ProdukSerialRepositoryInterface;

class DeleteProdukSerial
{
    public function __construct(
        private ProdukSerialRepositoryInterface $repo
    ) {}

    public function execute(int $id): ProdukSerial
    {
        return $this->repo->deleteProdukSerial($id);
    }
}
