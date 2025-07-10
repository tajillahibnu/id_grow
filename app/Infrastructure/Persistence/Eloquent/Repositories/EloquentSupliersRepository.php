<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Supliers\Entities\Supliers as SupliersEntity;
use App\Domain\Supliers\Repositories\SupliersRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\Supliers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EloquentSupliersRepository extends EloquentBaseRepository implements SupliersRepositoryInterface
{
    protected function getModelClass(): string
    {
        return Supliers::class;
    }

    protected function toEntity(Supliers $model): SupliersEntity
    {
        $entity = new SupliersEntity();

        $entity->id = $this->encodeId($model->id);
        $entity->kode = $model->kode;
        $entity->nama = $model->nama;
        $entity->kontak = $model->kontak;
        $entity->email = $model->email;
        $entity->alamat = $model->alamat;
        $entity->catatan = $model->catatan;

        return $entity;
    }

    public function fetchSupliers(string|int $limit = 10, int $offset = 0, string $sort = 'asc'): array
    {
        $query = $this->buildQuery(fn($q) => $q->orderBy('id', $sort));

        if ($limit !== 'all') {
            $query->offset($offset)->limit($limit);
        }

        return $query->get()
            ->map(fn($item) => $this->toEntity($item))
            ->toArray();
    }

    public function getSupliersById(int $id): ?SupliersEntity
    {
        $model = $this->buildQuery(fn($q) => $q->where('id', $id))->first();

        return $model ? $this->toEntity($model) : null;
    }

    public function storeSupliers(SupliersEntity $entity): ?SupliersEntity
    {
        $model = $this->buildCreate($entity);

        return $this->toEntity($model);
    }

    public function updateSupliers(int $id, SupliersEntity $entity): ?SupliersEntity
    {
        $model = $this->buildUpdate($id, $entity);

        return $this->toEntity($model);
    }

    public function deleteSupliers(int $id): ?SupliersEntity
    {
        $model = $this->buildDelete($id);

        return $model ? $this->toEntity($model) : null;
    }

    public function restoreSupliers(int $id): ?SupliersEntity
    {
        $model = $this->buildRestore($id);

        return $model ? $this->toEntity($model) : null;
    }
}
