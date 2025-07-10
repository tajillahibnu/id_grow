<?php

namespace App\Application\SatuanProduk\UseCase;

use App\Domain\SatuanProduk\Entities\SatuanProduk;
use App\Domain\SatuanProduk\Repositories\SatuanProdukRepositoryInterface;
use Exception;

class GetSatuanProduk
{
    public function __construct(
        private SatuanProdukRepositoryInterface $repo
    ) {}

    public function execute(string|int $limit = 10, int $offset = 0, string $sort = 'asc'): array
    {
        $items = $this->repo->fetchSatuanProduk($limit, $offset, $sort);
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
