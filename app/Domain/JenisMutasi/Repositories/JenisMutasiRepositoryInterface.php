<?php

namespace App\Domain\JenisMutasi\Repositories;

use App\Domain\JenisMutasi\Entities\JenisMutasi;

interface JenisMutasiRepositoryInterface
{
    public function fetchJenisMutasi(string|int $limit = 5, int $offset = 0, string $sort = 'asc'): array;
    public function getJenisMutasiById(int $id): ?JenisMutasi;
    public function storeJenisMutasi(JenisMutasi $params): ?JenisMutasi;
    public function updateJenisMutasi(int $id, JenisMutasi $params): ?JenisMutasi;
    public function deleteJenisMutasi(int $id): ?JenisMutasi;
}
