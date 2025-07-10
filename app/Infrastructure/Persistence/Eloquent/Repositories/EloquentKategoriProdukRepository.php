<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\KategoriProduk\Entities\KategoriProduk as KategoriProdukEntity;
use App\Domain\KategoriProduk\Repositories\KategoriProdukRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\KategoriProduk;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EloquentKategoriProdukRepository extends EloquentBaseRepository implements KategoriProdukRepositoryInterface
{
    protected function getModelClass(): string
    {
        return KategoriProduk::class;
    }

    protected function toEntity(KategoriProduk $model): KategoriProdukEntity
    {
        $entity = new KategoriProdukEntity();

        $entity->id = $this->encodeId($model->id);
                $entity->kode = $model->kode;
        $entity->name = $model->name;
        // $entity->name = $model->name;
        // Tambahkan semua properti yang relevan

        return $entity;
    }

    public function fetchKategoriProduk(string|int $limit = 10, int $offset = 0, string $sort = 'asc'): array
    {
        $query = $this->buildQuery(fn($q) => $q->orderBy('id', $sort));

        if ($limit !== 'all') {
            $query->offset($offset)->limit($limit);
        }

        return $query->get()
            ->map(fn($item) => $this->toEntity($item))
            ->toArray();
    }

    public function getKategoriProdukById(int $id): ?KategoriProdukEntity
    {
        $model = $this->buildQuery(fn($q) => $q->where('id', $id))->first();

        return $model ? $this->toEntity($model) : null;
    }

    public function storeKategoriProduk(KategoriProdukEntity $entity): ?KategoriProdukEntity
    {
        $model = $this->buildCreate($entity);

        return $this->toEntity($model);
    }

    public function updateKategoriProduk(int $id, KategoriProdukEntity $entity): ?KategoriProdukEntity
    {
        $model = $this->buildUpdate($id, $entity);

        return $this->toEntity($model);
    }

    public function deleteKategoriProduk(int $id): ?KategoriProdukEntity
    {
        $model = $this->buildDelete($id);

        return $model ? $this->toEntity($model) : null;
    }

    public function restoreKategoriProduk(int $id): ?KategoriProdukEntity
    {
        $model = $this->buildRestore($id);

        return $model ? $this->toEntity($model) : null;
    }
}
