<?php

namespace App\Application\SatuanProduk\UseCase;

use App\Domain\SatuanProduk\Entities\SatuanProduk;
use App\Domain\SatuanProduk\Repositories\SatuanProdukRepositoryInterface;

class DeleteSatuanProduk
{
    public function __construct(
        private SatuanProdukRepositoryInterface $repo
    ) {}

    public function execute(int $id): SatuanProduk
    {
        return $this->repo->deleteSatuanProduk($id);
    }
}
