<?php

namespace App\Application\Lokasi\UseCase;

use App\Domain\Lokasi\Entities\Lokasi;
use App\Domain\Lokasi\Repositories\LokasiRepositoryInterface;

class DeleteLokasi
{
    public function __construct(
        private LokasiRepositoryInterface $repo
    ) {}

    public function execute(int $id): Lokasi
    {
        return $this->repo->deleteLokasi($id);
    }
}
