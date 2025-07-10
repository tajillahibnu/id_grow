<?php

namespace App\Application\JenisMutasi\UseCase;

use App\Domain\JenisMutasi\Entities\JenisMutasi;
use App\Domain\JenisMutasi\Repositories\JenisMutasiRepositoryInterface;
use Exception;

class GetJenisMutasiById
{
    public function __construct(
        private JenisMutasiRepositoryInterface $repo
    ) {}

    public function execute(int $id): JenisMutasi
    {
        $item = $this->repo->getJenisMutasiById($id);

        if (!$item) {
            throw new Exception("Data tidak ditemukan");
        }
        return $item;
    }
}
