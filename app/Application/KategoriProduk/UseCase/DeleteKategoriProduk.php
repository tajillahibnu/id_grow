<?php

namespace App\Application\KategoriProduk\UseCase;

use App\Domain\KategoriProduk\Entities\KategoriProduk;
use App\Domain\KategoriProduk\Repositories\KategoriProdukRepositoryInterface;

class DeleteKategoriProduk
{
    public function __construct(
        private KategoriProdukRepositoryInterface $repo
    ) {}

    public function execute(int $id): KategoriProduk
    {
        return $this->repo->deleteKategoriProduk($id);
    }
}
