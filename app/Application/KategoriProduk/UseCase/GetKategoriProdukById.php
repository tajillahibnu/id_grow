<?php

namespace App\Application\KategoriProduk\UseCase;

use App\Domain\KategoriProduk\Entities\KategoriProduk;
use App\Domain\KategoriProduk\Repositories\KategoriProdukRepositoryInterface;
use Exception;

class GetKategoriProdukById
{
    public function __construct(
        private KategoriProdukRepositoryInterface $repo
    ) {}

    public function execute(int $id): KategoriProduk
    {
        $item = $this->repo->getKategoriProdukById($id);

        if (!$item) {
            throw new Exception("Data tidak ditemukan");
        }
        return $item;
    }
}
