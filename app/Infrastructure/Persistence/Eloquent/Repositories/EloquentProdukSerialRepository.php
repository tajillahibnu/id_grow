<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\ProdukSerial\Entities\ProdukSerial as ProdukSerialEntity;
use App\Domain\ProdukSerial\Repositories\ProdukSerialRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\ProdukSerial;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EloquentProdukSerialRepository extends EloquentBaseRepository implements ProdukSerialRepositoryInterface
{
    protected function getModelClass(): string
    {
        return ProdukSerial::class;
    }

    protected function toEntity(ProdukSerial $model): ProdukSerialEntity
    {
        $entity = new ProdukSerialEntity();

        $entity->id = $this->encodeId($model->id);
                $entity->produk_id = $model->produk_id;
        $entity->lokasi_id = $model->lokasi_id;
        $entity->serial_number = $model->serial_number;
        $entity->barcode = $model->barcode;
        $entity->batch_number = $model->batch_number;
        $entity->tanggal_produksi = $model->tanggal_produksi;
        $entity->expired_at = $model->expired_at;
        $entity->garansi_sampai = $model->garansi_sampai;
        $entity->status = $model->status;
        $entity->mutasi_id = $model->mutasi_id;
        $entity->user_id = $model->user_id;
        $entity->keterangan = $model->keterangan;
        // $entity->name = $model->name;
        // Tambahkan semua properti yang relevan

        return $entity;
    }

    public function fetchProdukSerial(string|int $limit = 10, int $offset = 0, string $sort = 'asc'): array
    {
        $query = $this->buildQuery(fn($q) => $q->orderBy('id', $sort));

        if ($limit !== 'all') {
            $query->offset($offset)->limit($limit);
        }

        return $query->get()
            ->map(fn($item) => $this->toEntity($item))
            ->toArray();
    }

    public function getProdukSerialById(int $id): ?ProdukSerialEntity
    {
        $model = $this->buildQuery(fn($q) => $q->where('id', $id))->first();

        return $model ? $this->toEntity($model) : null;
    }

    public function storeProdukSerial(ProdukSerialEntity $entity): ?ProdukSerialEntity
    {
        $model = $this->buildCreate($entity);

        return $this->toEntity($model);
    }

    public function updateProdukSerial(int $id, ProdukSerialEntity $entity): ?ProdukSerialEntity
    {
        $model = $this->buildUpdate($id, $entity);

        return $this->toEntity($model);
    }

    public function deleteProdukSerial(int $id): ?ProdukSerialEntity
    {
        $model = $this->buildDelete($id);

        return $model ? $this->toEntity($model) : null;
    }

    public function restoreProdukSerial(int $id): ?ProdukSerialEntity
    {
        $model = $this->buildRestore($id);

        return $model ? $this->toEntity($model) : null;
    }
}
