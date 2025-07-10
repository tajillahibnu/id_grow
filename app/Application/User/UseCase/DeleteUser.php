<?php

namespace App\Application\User\UseCase;

use App\Domain\User\Entities\User;
use App\Domain\User\Repositories\UserRepositoryInterface;

class DeleteUser
{
    public function __construct(
        private UserRepositoryInterface $repo
    ) {}

    public function execute(int $id): User
    {
        return $this->repo->deleteUser($id);
    }
}
