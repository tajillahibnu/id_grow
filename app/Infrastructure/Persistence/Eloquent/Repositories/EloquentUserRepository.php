<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\User\Entities\User as UserEntity;
use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Domain\User\Services\UserService;
use App\Infrastructure\Persistence\Eloquent\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EloquentUserRepository extends EloquentBaseRepository implements UserRepositoryInterface
{
    public function __construct(
        private UserService $service,

    ) {}
    protected function getModelClass(): string
    {
        return User::class;
    }

    protected function toEntity(User $model): UserEntity
    {
        $entity = new UserEntity();

        $entity->id = $this->encodeId($model->id);
        $entity->name = $model->name;
        $entity->email = $model->email;
        $entity->password = $model->password;

        return $entity;
    }

    public function fetchUser(string|int $limit = 10, int $offset = 0, string $sort = 'asc'): array
    {
        $query = $this->buildQuery(fn($q) => $q->orderBy('id', $sort));

        if ($limit !== 'all') {
            $query->offset($offset)->limit($limit);
        }

        return $query->get()
            ->map(fn($item) => $this->toEntity($item))
            ->toArray();
    }

    public function getUserById(int $id): ?UserEntity
    {
        $model = $this->buildQuery(fn($q) => $q->where('id', $id))->first();

        return $model ? $this->toEntity($model) : null;
    }

    public function storeUser(UserEntity $entity): ?UserEntity
    {
        $entity->password = $this->service->password($entity->password);
        $entity->password = $this->service->password('password');
        $model = $this->buildCreate($entity);

        return $this->toEntity($model);
    }

    public function updateUser(int $id, UserEntity $entity): ?UserEntity
    {
        $model = $this->buildUpdate($id, $entity);

        return $this->toEntity($model);
    }

    public function deleteUser(int $id): ?UserEntity
    {
        $model = $this->buildDelete($id);

        return $model ? $this->toEntity($model) : null;
    }

    public function restoreUser(int $id): ?UserEntity
    {
        $model = $this->buildRestore($id);

        return $model ? $this->toEntity($model) : null;
    }
}
