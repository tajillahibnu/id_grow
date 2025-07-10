<?php

namespace App\Application\ProdukSerial\UseCase;

use App\Domain\ProdukSerial\Entities\ProdukSerial;
use App\Domain\ProdukSerial\Repositories\ProdukSerialRepositoryInterface;
use Exception;

class GetProdukSerial
{
    public function __construct(
        private ProdukSerialRepositoryInterface $repo
    ) {}

    public function execute(string|int $limit = 10, int $offset = 0, string $sort = 'asc'): array
    {
        $items = $this->repo->fetchProdukSerial($limit, $offset, $sort);
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
