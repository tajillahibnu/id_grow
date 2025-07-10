<?php

namespace App\Application\Mutasi\UseCase;

use App\Domain\Mutasi\Repositories\MutasiRepositoryInterface;
use App\Domain\Produk\Repositories\ProdukRepositoryInterface;
use Exception;

class GetMutasiHistoryByProduk
{
    public function __construct(
        private ProdukRepositoryInterface $produkRepo,
        private MutasiRepositoryInterface $mutasiRepo,
    ) {}

    public function execute(int|string $produkId): array
    {
        $produk = $this->produkRepo->findById($produkId);
        if (!$produk) {
            throw new \Exception("Produk tidak ditemukan");
        }

        return $this->mutasiRepo->getHistoryByProdukId($produk['id']);
    }
}
