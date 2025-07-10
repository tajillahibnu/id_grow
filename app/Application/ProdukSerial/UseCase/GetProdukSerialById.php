<?php

namespace App\Application\ProdukSerial\UseCase;

use App\Domain\ProdukSerial\Entities\ProdukSerial;
use App\Domain\ProdukSerial\Repositories\ProdukSerialRepositoryInterface;
use Exception;

class GetProdukSerialById
{
    public function __construct(
        private ProdukSerialRepositoryInterface $repo
    ) {}

    public function execute(int $id): ProdukSerial
    {
        $item = $this->repo->getProdukSerialById($id);

        if (!$item) {
            throw new Exception("Data tidak ditemukan");
        }
        return $item;
    }
}
