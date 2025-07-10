<?php

namespace App\Application\JenisMutasi\UseCase;

use App\Application\JenisMutasi\DTOs\JenisMutasiDTO;
use App\Domain\JenisMutasi\Entities\JenisMutasi;
use App\Domain\JenisMutasi\Repositories\JenisMutasiRepositoryInterface;

class UpdateJenisMutasi
{
    public function __construct(
        private JenisMutasiRepositoryInterface $repo,
    ) {}

    public function execute(JenisMutasiDTO $dto, int $id): JenisMutasi
    {
        $entity = JenisMutasi::fromDTO($dto);
        return $this->repo->updateJenisMutasi($id, $entity);
    }
}
