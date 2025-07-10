<?php

namespace App\Application\Produk\UseCase;

use App\Domain\Produk\Entities\Produk;
use App\Domain\Produk\Repositories\ProdukRepositoryInterface;
use Exception;

class GetProdukById
{
    public function __construct(
        private ProdukRepositoryInterface $repo
    ) {}

    public function execute(int $id): Produk
    {
        $item = $this->repo->getProdukById($id);

        if (!$item) {
            throw new Exception("Data tidak ditemukan");
        }
        return $item;
    }
}
