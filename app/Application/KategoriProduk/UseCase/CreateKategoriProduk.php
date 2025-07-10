<?php

namespace App\Application\KategoriProduk\UseCase;

use App\Application\KategoriProduk\DTOs\KategoriProdukDTO;
use App\Domain\KategoriProduk\Entities\KategoriProduk;
use App\Domain\KategoriProduk\Repositories\KategoriProdukRepositoryInterface;

class CreateKategoriProduk
{
    public function __construct(
        private KategoriProdukRepositoryInterface $repo,
    ) {}

    public function execute(KategoriProdukDTO $dto): KategoriProduk
    {
        $entity = KategoriProduk::fromDTO($dto);
        return $this->repo->storeKategoriProduk($entity);
    }
}
