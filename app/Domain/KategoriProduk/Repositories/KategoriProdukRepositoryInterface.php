<?php

namespace App\Domain\KategoriProduk\Repositories;

use App\Domain\KategoriProduk\Entities\KategoriProduk;

interface KategoriProdukRepositoryInterface
{
    public function fetchKategoriProduk(string|int $limit = 5, int $offset = 0, string $sort = 'asc'): array;
    public function getKategoriProdukById(int $id): ?KategoriProduk;
    public function storeKategoriProduk(KategoriProduk $params): ?KategoriProduk;
    public function updateKategoriProduk(int $id, KategoriProduk $params): ?KategoriProduk;
    public function deleteKategoriProduk(int $id): ?KategoriProduk;
}
