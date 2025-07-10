<?php

namespace App\Application\JenisMutasi\UseCase;

use App\Domain\JenisMutasi\Entities\JenisMutasi;
use App\Domain\JenisMutasi\Repositories\JenisMutasiRepositoryInterface;
use Exception;

class GetJenisMutasi
{
    public function __construct(
        private JenisMutasiRepositoryInterface $repo
    ) {}

    public function execute(string|int $limit = 10, int $offset = 0, string $sort = 'asc'): array
    {
        $items = $this->repo->fetchJenisMutasi($limit, $offset, $sort);
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
