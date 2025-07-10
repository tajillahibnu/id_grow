<?php

namespace App\Application\Lokasi\UseCase;

use App\Domain\Lokasi\Entities\Lokasi;
use App\Domain\Lokasi\Repositories\LokasiRepositoryInterface;
use Exception;

class GetLokasiById
{
    public function __construct(
        private LokasiRepositoryInterface $repo
    ) {}

    public function execute(int $id): Lokasi
    {
        $item = $this->repo->getLokasiById($id);

        if (!$item) {
            throw new Exception("Data tidak ditemukan");
        }
        return $item;
    }
}
