<?php

namespace App\Domain\User\Repositories;

use App\Domain\User\Entities\User;

interface UserRepositoryInterface
{
    public function fetchUser(string|int $limit = 5, int $offset = 0, string $sort = 'asc'): array;
    public function getUserById(int $id): ?User;
    public function storeUser(User $params): ?User;
    public function updateUser(int $id, User $params): ?User;
    public function deleteUser(int $id): ?User;
}
