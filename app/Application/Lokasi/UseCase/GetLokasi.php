<?php

namespace App\Application\Lokasi\UseCase;

use App\Domain\Lokasi\Entities\Lokasi;
use App\Domain\Lokasi\Repositories\LokasiRepositoryInterface;
use Exception;

class GetLokasi
{
    public function __construct(
        private LokasiRepositoryInterface $repo
    ) {}

    public function execute(string|int $limit = 10, int $offset = 0, string $sort = 'asc'): array
    {
        $items = $this->repo->fetchLokasi($limit, $offset, $sort);
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
