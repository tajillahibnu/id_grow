<?php

namespace App\Domain\Mutasi\Repositories;

interface MutasiRepositoryInterface
{
    public function getHistoryByProdukId(int $produkId): array;

    public function getHistoryByUserId(int $userId): array;
}

