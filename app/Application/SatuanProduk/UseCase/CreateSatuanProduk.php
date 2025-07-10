<?php

namespace App\Application\SatuanProduk\UseCase;

use App\Application\SatuanProduk\DTOs\SatuanProdukDTO;
use App\Domain\SatuanProduk\Entities\SatuanProduk;
use App\Domain\SatuanProduk\Repositories\SatuanProdukRepositoryInterface;

class CreateSatuanProduk
{
    public function __construct(
        private SatuanProdukRepositoryInterface $repo,
    ) {}

    public function execute(SatuanProdukDTO $dto): SatuanProduk
    {
        $entity = SatuanProduk::fromDTO($dto);
        return $this->repo->storeSatuanProduk($entity);
    }
}
