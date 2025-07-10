<?php

namespace App\Domain\Transfer\Repositories;

use App\Domain\Transfer\Entities\Transfer;

interface TransferRepositoryInterface
{
    public function getTransferById(int $id): ?array;
    public function getTransferByKode(string $kode): ?array;
    public function getTransferDetailById(int $id): ?array;
    public function storeTransfer(Transfer $params): ?array;
    public function storeTransferDetails(string|int $id, array $params): ?array;
    public function updateTransfer(int $id, array $params): ?array;



    public function fetchTransfer(string|int $limit = 5, int $offset = 0, string $sort = 'asc'): array;
}
