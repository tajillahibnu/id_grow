<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Lokasi\Entities\Lokasi as LokasiEntity;
use App\Domain\Lokasi\Repositories\LokasiRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\Lokasi;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EloquentLokasiRepository extends EloquentBaseRepository implements LokasiRepositoryInterface
{
    protected function getModelClass(): string
    {
        return Lokasi::class;
    }

    protected function toEntity(Lokasi $model): LokasiEntity
    {
        $entity = new LokasiEntity();

        $entity->id = $this->encodeId($model->id);
                $entity->kode = $model->kode;
        $entity->name = $model->name;
        $entity->alamat = $model->alamat;
        $entity->kontak = $model->kontak;
        // $entity->name = $model->name;
        // Tambahkan semua properti yang relevan

        return $entity;
    }

    public function fetchLokasi(string|int $limit = 10, int $offset = 0, string $sort = 'asc'): array
    {
        $query = $this->buildQuery(fn($q) => $q->orderBy('id', $sort));

        if ($limit !== 'all') {
            $query->offset($offset)->limit($limit);
        }

        return $query->get()
            ->map(fn($item) => $this->toEntity($item))
            ->toArray();
    }

    public function getLokasiById(int $id): ?LokasiEntity
    {
        $model = $this->buildQuery(fn($q) => $q->where('id', $id))->first();

        return $model ? $this->toEntity($model) : null;
    }

    public function storeLokasi(LokasiEntity $entity): ?LokasiEntity
    {
        $model = $this->buildCreate($entity);

        return $this->toEntity($model);
    }

    public function updateLokasi(int $id, LokasiEntity $entity): ?LokasiEntity
    {
        $model = $this->buildUpdate($id, $entity);

        return $this->toEntity($model);
    }

    public function deleteLokasi(int $id): ?LokasiEntity
    {
        $model = $this->buildDelete($id);

        return $model ? $this->toEntity($model) : null;
    }

    public function restoreLokasi(int $id): ?LokasiEntity
    {
        $model = $this->buildRestore($id);

        return $model ? $this->toEntity($model) : null;
    }
}
