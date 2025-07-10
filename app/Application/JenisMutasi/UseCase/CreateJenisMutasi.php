<?php

namespace App\Application\JenisMutasi\UseCase;

use App\Application\JenisMutasi\DTOs\JenisMutasiDTO;
use App\Domain\JenisMutasi\Entities\JenisMutasi;
use App\Domain\JenisMutasi\Repositories\JenisMutasiRepositoryInterface;

class CreateJenisMutasi
{
    public function __construct(
        private JenisMutasiRepositoryInterface $repo,
    ) {}

    public function execute(JenisMutasiDTO $dto): JenisMutasi
    {
        $entity = JenisMutasi::fromDTO($dto);
        return $this->repo->storeJenisMutasi($entity);
    }
}
