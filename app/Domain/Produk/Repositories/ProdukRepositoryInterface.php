<?php

namespace App\Domain\Produk\Repositories;

use App\Domain\Produk\Entities\Produk;

interface ProdukRepositoryInterface
{
    public function fetchProduk(string|int $limit = 5, int $offset = 0, string $sort = 'asc'): array;
    public function getProdukById(int $id): ?Produk;
    public function storeProduk(Produk $params): ?Produk;
    public function updateProduk(int $id, Produk $params): ?Produk;
    public function deleteProduk(int $id): ?Produk;

    public function findById(int|string $id): ?array;
}
