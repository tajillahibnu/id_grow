<?php

namespace App\Application\User\UseCase;

use App\Domain\User\Entities\User;
use App\Domain\User\Repositories\UserRepositoryInterface;
use Exception;

class GetUser
{
    public function __construct(
        private UserRepositoryInterface $repo
    ) {}

    public function execute(string|int $limit = 10, int $offset = 0, string $sort = 'asc'): array
    {
        $items = $this->repo->fetchUser($limit, $offset, $sort);
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
