<?php

namespace App\Application\User\UseCase;

use App\Application\User\DTOs\UserDTO;
use App\Domain\User\Entities\User;
use App\Domain\User\Repositories\UserRepositoryInterface;

class CreateUser
{
    public function __construct(
        private UserRepositoryInterface $repo,
    ) {}

    public function execute(UserDTO $dto): User
    {
        $entity = User::fromDTO($dto);
        return $this->repo->storeUser($entity);
    }
}
