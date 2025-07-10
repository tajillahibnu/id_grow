<?php

namespace App\Domain\SatuanProduk\Repositories;

use App\Domain\SatuanProduk\Entities\SatuanProduk;

interface SatuanProdukRepositoryInterface
{
    public function fetchSatuanProduk(string|int $limit = 5, int $offset = 0, string $sort = 'asc'): array;
    public function getSatuanProdukById(int $id): ?SatuanProduk;
    public function storeSatuanProduk(SatuanProduk $params): ?SatuanProduk;
    public function updateSatuanProduk(int $id, SatuanProduk $params): ?SatuanProduk;
    public function deleteSatuanProduk(int $id): ?SatuanProduk;
}
