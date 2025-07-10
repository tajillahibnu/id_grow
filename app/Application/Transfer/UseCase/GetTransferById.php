<?php

namespace App\Application\Transfer\UseCase;

use App\Domain\Transfer\Entities\Transfer;
use App\Domain\Transfer\Repositories\TransferRepositoryInterface;
use Exception;

class GetTransferById
{
    public function __construct(
        private TransferRepositoryInterface $repo
    ) {}

    public function execute(int $id): array
    {
        $item = $this->repo->getTransferById($id);
        
        if (!$item) {
            throw new Exception("Data tidak ditemukan");
        }
        $detail = $this->repo->getTransferDetailById($id);
        $item['detail'] = $detail;
        return $item;
    }
}
