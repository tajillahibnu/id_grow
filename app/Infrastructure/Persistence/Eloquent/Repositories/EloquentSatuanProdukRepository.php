<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\SatuanProduk\Entities\SatuanProduk as SatuanProdukEntity;
use App\Domain\SatuanProduk\Repositories\SatuanProdukRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\SatuanProduk;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EloquentSatuanProdukRepository extends EloquentBaseRepository implements SatuanProdukRepositoryInterface
{
    protected function getModelClass(): string
    {
        return SatuanProduk::class;
    }

    protected function toEntity(SatuanProduk $model): SatuanProdukEntity
    {
        $entity = new SatuanProdukEntity();

        $entity->id = $this->encodeId($model->id);
                $entity->kode = $model->kode;
        $entity->name = $model->name;
        // $entity->name = $model->name;
        // Tambahkan semua properti yang relevan

        return $entity;
    }

    public function fetchSatuanProduk(string|int $limit = 10, int $offset = 0, string $sort = 'asc'): array
    {
        $query = $this->buildQuery(fn($q) => $q->orderBy('id', $sort));

        if ($limit !== 'all') {
            $query->offset($offset)->limit($limit);
        }

        return $query->get()
            ->map(fn($item) => $this->toEntity($item))
            ->toArray();
    }

    public function getSatuanProdukById(int $id): ?SatuanProdukEntity
    {
        $model = $this->buildQuery(fn($q) => $q->where('id', $id))->first();

        return $model ? $this->toEntity($model) : null;
    }

    public function storeSatuanProduk(SatuanProdukEntity $entity): ?SatuanProdukEntity
    {
        $model = $this->buildCreate($entity);

        return $this->toEntity($model);
    }

    public function updateSatuanProduk(int $id, SatuanProdukEntity $entity): ?SatuanProdukEntity
    {
        $model = $this->buildUpdate($id, $entity);

        return $this->toEntity($model);
    }

    public function deleteSatuanProduk(int $id): ?SatuanProdukEntity
    {
        $model = $this->buildDelete($id);

        return $model ? $this->toEntity($model) : null;
    }

    public function restoreSatuanProduk(int $id): ?SatuanProdukEntity
    {
        $model = $this->buildRestore($id);

        return $model ? $this->toEntity($model) : null;
    }
}
