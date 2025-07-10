<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\JenisMutasi\Entities\JenisMutasi as JenisMutasiEntity;
use App\Domain\JenisMutasi\Repositories\JenisMutasiRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\JenisMutasi;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EloquentJenisMutasiRepository extends EloquentBaseRepository implements JenisMutasiRepositoryInterface
{
    protected function getModelClass(): string
    {
        return JenisMutasi::class;
    }

    protected function toEntity(JenisMutasi $model): JenisMutasiEntity
    {
        $entity = new JenisMutasiEntity();

        $entity->id = $this->encodeId($model->id);
                $entity->kode = $model->kode;
        $entity->name = $model->name;
        $entity->efek_stok = $model->efek_stok;
        $entity->aktif = $model->aktif;
        // $entity->name = $model->name;
        // Tambahkan semua properti yang relevan

        return $entity;
    }

    public function fetchJenisMutasi(string|int $limit = 10, int $offset = 0, string $sort = 'asc'): array
    {
        $query = $this->buildQuery(fn($q) => $q->orderBy('id', $sort));

        if ($limit !== 'all') {
            $query->offset($offset)->limit($limit);
        }

        return $query->get()
            ->map(fn($item) => $this->toEntity($item))
            ->toArray();
    }

    public function getJenisMutasiById(int $id): ?JenisMutasiEntity
    {
        $model = $this->buildQuery(fn($q) => $q->where('id', $id))->first();

        return $model ? $this->toEntity($model) : null;
    }

    public function storeJenisMutasi(JenisMutasiEntity $entity): ?JenisMutasiEntity
    {
        $model = $this->buildCreate($entity);

        return $this->toEntity($model);
    }

    public function updateJenisMutasi(int $id, JenisMutasiEntity $entity): ?JenisMutasiEntity
    {
        $model = $this->buildUpdate($id, $entity);

        return $this->toEntity($model);
    }

    public function deleteJenisMutasi(int $id): ?JenisMutasiEntity
    {
        $model = $this->buildDelete($id);

        return $model ? $this->toEntity($model) : null;
    }

    public function restoreJenisMutasi(int $id): ?JenisMutasiEntity
    {
        $model = $this->buildRestore($id);

        return $model ? $this->toEntity($model) : null;
    }
}
