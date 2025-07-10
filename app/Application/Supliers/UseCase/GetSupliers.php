<?php

namespace App\Application\Supliers\UseCase;

use App\Domain\Supliers\Entities\Supliers;
use App\Domain\Supliers\Repositories\SupliersRepositoryInterface;
use Exception;

class GetSupliers
{
    public function __construct(
        private SupliersRepositoryInterface $repo
    ) {}

    public function execute(string|int $limit = 10, int $offset = 0, string $sort = 'asc'): array
    {
        $items = $this->repo->fetchSupliers($limit, $offset, $sort);
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
