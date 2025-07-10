<?php

namespace App\Application\Produk\UseCase;

use App\Domain\Produk\Entities\Produk;
use App\Domain\Produk\Repositories\ProdukRepositoryInterface;

class DeleteProduk
{
    public function __construct(
        private ProdukRepositoryInterface $repo
    ) {}

    public function execute(int $id): Produk
    {
        return $this->repo->deleteProduk($id);
    }
}
