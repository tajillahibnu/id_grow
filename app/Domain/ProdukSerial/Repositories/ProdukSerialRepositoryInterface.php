<?php

namespace App\Domain\ProdukSerial\Repositories;

use App\Domain\ProdukSerial\Entities\ProdukSerial;

interface ProdukSerialRepositoryInterface
{
    public function fetchProdukSerial(string|int $limit = 5, int $offset = 0, string $sort = 'asc'): array;
    public function getProdukSerialById(int $id): ?ProdukSerial;
    public function storeProdukSerial(ProdukSerial $params): ?ProdukSerial;
    public function updateProdukSerial(int $id, ProdukSerial $params): ?ProdukSerial;
    public function deleteProdukSerial(int $id): ?ProdukSerial;
}
