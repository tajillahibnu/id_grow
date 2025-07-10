<?php

namespace App\Application\Lokasi\UseCase;

use App\Application\Lokasi\DTOs\LokasiDTO;
use App\Domain\Lokasi\Entities\Lokasi;
use App\Domain\Lokasi\Repositories\LokasiRepositoryInterface;

class CreateLokasi
{
    public function __construct(
        private LokasiRepositoryInterface $repo,
    ) {}

    public function execute(LokasiDTO $dto): Lokasi
    {
        $entity = Lokasi::fromDTO($dto);
        return $this->repo->storeLokasi($entity);
    }
}
