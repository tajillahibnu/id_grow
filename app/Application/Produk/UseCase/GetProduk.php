<?php

namespace App\Application\Produk\UseCase;

use App\Domain\Produk\Entities\Produk;
use App\Domain\Produk\Repositories\ProdukRepositoryInterface;
use Exception;

class GetProduk
{
    public function __construct(
        private ProdukRepositoryInterface $repo
    ) {}

    public function execute(string|int $limit = 10, int $offset = 0, string $sort = 'asc'): array
    {
        $items = $this->repo->fetchProduk($limit, $offset, $sort);
        return [
            'meta' => [
                'limit'  => $limit,
                'offset' => $offset,
                'sort'   => $sort,
                'count'  => count($items),
            ],
            'data' => $items
        ];
    }
}
