<?php

namespace App\Application\User\UseCase;

use App\Domain\User\Entities\User;
use App\Domain\User\Repositories\UserRepositoryInterface;
use Exception;

class GetUserById
{
    public function __construct(
        private UserRepositoryInterface $repo
    ) {}

    public function execute(int $id): User
    {
        $item = $this->repo->getUserById($id);

        if (!$item) {
            throw new Exception("Data tidak ditemukan");
        }
        return $item;
    }
}
