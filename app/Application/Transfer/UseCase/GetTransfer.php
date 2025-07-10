<?php

namespace App\Application\Transfer\UseCase;

use App\Domain\Transfer\Entities\Transfer;
use App\Domain\Transfer\Repositories\TransferRepositoryInterface;
use Exception;

class GetTransfer
{
    public function __construct(
        private TransferRepositoryInterface $repo
    ) {}

    public function execute(string|int $limit = 10, int $offset = 0, string $sort = 'asc'): array
    {
        $items = $this->repo->fetchTransfer($limit, $offset, $sort);
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
