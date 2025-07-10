<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Produk\Entities\Produk as ProdukEntity;
use App\Domain\Produk\Repositories\ProdukRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\Produk;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EloquentProdukRepository extends EloquentBaseRepository implements ProdukRepositoryInterface
{
    protected function getModelClass(): string
    {
        return Produk::class;
    }

    public function findById(int|string $id): ?array
    {
        $produk = is_numeric($id)
            ? Produk::with('kategori', 'satuan')->find($id)
            : Produk::with('kategori', 'satuan')->where('kode', $id)->first();

        return $produk?->toArray();
    }

    protected function toEntity(Produk $model): ProdukEntity
    {
        $entity = new ProdukEntity();

        $entity->id = $this->encodeId($model->id);
        $entity->kode = $model->kode;
        $entity->name = $model->name;
        $entity->kategori_produk_id = $model->kategori_produk_id;
        $entity->satuan_produk_id = $model->satuan_produk_id;
        $entity->deskripsi = $model->deskripsi;
        // $entity->name = $model->name;
        // Tambahkan semua properti yang relevan

        return $entity;
    }

    public function fetchProduk(string|int $limit = 10, int $offset = 0, string $sort = 'asc'): array
    {
        $query = DB::table('view_produk')
            ->select('id', 'kode', 'name', 'kategori_name', 'satuan_name', 'deskripsi')
            ->orderBy('id', $sort);

        if ($limit !== 'all') {
            $query->offset($offset)->limit($limit);
        }

        $produkData = $query->get();

        return $produkData->map(function ($model) {
            $entity = (array) $model;
            $entity['id'] = $this->encodeId($model->id);
            return $entity;
        })->toArray();
    }

    public function getProdukById(int $id): ?ProdukEntity
    {
        $model = $this->buildQuery(fn($q) => $q->where('id', $id))->first();

        return $model ? $this->toEntity($model) : null;
    }

    public function storeProduk(ProdukEntity $entity): ?ProdukEntity
    {
        $model = $this->buildCreate($entity);

        return $this->toEntity($model);
    }

    public function updateProduk(int $id, ProdukEntity $entity): ?ProdukEntity
    {
        $model = $this->buildUpdate($id, $entity);

        return $this->toEntity($model);
    }

    public function deleteProduk(int $id): ?ProdukEntity
    {
        $model = $this->buildDelete($id);

        return $model ? $this->toEntity($model) : null;
    }

    public function restoreProduk(int $id): ?ProdukEntity
    {
        $model = $this->buildRestore($id);

        return $model ? $this->toEntity($model) : null;
    }
}
