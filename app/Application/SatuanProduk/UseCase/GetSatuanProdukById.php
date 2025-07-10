<?php

namespace App\Application\SatuanProduk\UseCase;

use App\Domain\SatuanProduk\Entities\SatuanProduk;
use App\Domain\SatuanProduk\Repositories\SatuanProdukRepositoryInterface;
use Exception;

class GetSatuanProdukById
{
    public function __construct(
        private SatuanProdukRepositoryInterface $repo
    ) {}

    public function execute(int $id): SatuanProduk
    {
        $item = $this->repo->getSatuanProdukById($id);

        if (!$item) {
            throw new Exception("Data tidak ditemukan");
        }
        return $item;
    }
}
