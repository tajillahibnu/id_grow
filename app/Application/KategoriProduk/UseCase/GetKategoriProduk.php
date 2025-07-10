<?php

namespace App\Application\KategoriProduk\UseCase;

use App\Domain\KategoriProduk\Entities\KategoriProduk;
use App\Domain\KategoriProduk\Repositories\KategoriProdukRepositoryInterface;
use Exception;

class GetKategoriProduk
{
    public function __construct(
        private KategoriProdukRepositoryInterface $repo
    ) {}

    public function execute(string|int $limit = 10, int $offset = 0, string $sort = 'asc'): array
    {
        $items = $this->repo->fetchKategoriProduk($limit, $offset, $sort);
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
