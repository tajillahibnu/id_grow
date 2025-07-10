<?php

namespace App\Application\Produk\UseCase;

use App\Application\Produk\DTOs\ProdukDTO;
use App\Domain\Produk\Entities\Produk;
use App\Domain\Produk\Repositories\ProdukRepositoryInterface;

class CreateProduk
{
    public function __construct(
        private ProdukRepositoryInterface $repo,
    ) {}

    public function execute(ProdukDTO $dto): Produk
    {
        $entity = Produk::fromDTO($dto);
        return $this->repo->storeProduk($entity);
    }
}
