<?php

namespace App\Application\JenisMutasi\UseCase;

use App\Domain\JenisMutasi\Entities\JenisMutasi;
use App\Domain\JenisMutasi\Repositories\JenisMutasiRepositoryInterface;

class DeleteJenisMutasi
{
    public function __construct(
        private JenisMutasiRepositoryInterface $repo
    ) {}

    public function execute(int $id): JenisMutasi
    {
        return $this->repo->deleteJenisMutasi($id);
    }
}
