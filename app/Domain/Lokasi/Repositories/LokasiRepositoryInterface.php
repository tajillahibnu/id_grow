<?php

namespace App\Domain\Lokasi\Repositories;

use App\Domain\Lokasi\Entities\Lokasi;

interface LokasiRepositoryInterface
{
    public function fetchLokasi(string|int $limit = 5, int $offset = 0, string $sort = 'asc'): array;
    public function getLokasiById(int $id): ?Lokasi;
    public function storeLokasi(Lokasi $params): ?Lokasi;
    public function updateLokasi(int $id, Lokasi $params): ?Lokasi;
    public function deleteLokasi(int $id): ?Lokasi;
}
