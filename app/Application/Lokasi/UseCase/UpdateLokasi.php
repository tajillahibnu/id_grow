<?php

namespace App\Application\Lokasi\UseCase;

use App\Application\Lokasi\DTOs\LokasiDTO;
use App\Domain\Lokasi\Entities\Lokasi;
use App\Domain\Lokasi\Repositories\LokasiRepositoryInterface;

class UpdateLokasi
{
    public function __construct(
        private LokasiRepositoryInterface $repo,
    ) {}

    public function execute(LokasiDTO $dto, int $id): Lokasi
    {
        $entity = Lokasi::fromDTO($dto);
        return $this->repo->updateLokasi($id, $entity);
    }
}
