<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait CrudBasicEloquentTrait
{
    protected Model $model;

    abstract protected function getModelClass(): string;

    public function buildQuery(?callable $callback = null): Builder
    {
        $query = $this->getModelClass()::query();

        if ($callback) {
            $callback($query); // modifikasi query secara dinamis
        }

        return $query;
    }
    /**
     * Buat record baru dari entitas domain
     * 
     * @param object $entity Entitas domain (misal JurnalKegiatanEntity)
     * @return Model|null
     */
    public function buildCreate(object $entity): ?Model
    {
        $modelClass = $this->getModelClass();
        $model = new $modelClass();

        if (method_exists($entity, 'toArray')) {
            $model->fill($entity->toArray());
        } else {
            foreach (get_object_vars($entity) as $key => $value) {
                $model->$key = $value;
            }
        }

        $model->save();

        return $model;
    }

    /**
     * Update record berdasarkan ID dan data entitas domain
     *
     * @param int|string $id
     * @param object $entity Entitas domain yang berisi data untuk update
     * @return Model
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function buildUpdate(int|string $id, object $entity): Model
    {
        $modelClass = $this->getModelClass();

        /** @var Model $model */
        $model = $modelClass::findOrFail($id);

        if (method_exists($entity, 'toArray')) {
            $model->fill($entity->toArray());
        } else {
            foreach (get_object_vars($entity) as $key => $value) {
                $model->$key = $value;
            }
        }

        $model->save();

        return $model;
    }

    /**
     * Soft delete record berdasarkan ID
     *
     * @param int|string $id
     * @return Model|null Model sebelum dihapus, atau null kalau tidak ditemukan
     *
     * @throws \DomainException Jika data tidak ditemukan
     */
    public function buildDelete(int|string $id): ?Model
    {
        $modelClass = $this->getModelClass();

        $model = $modelClass::find($id);

        if (!$model) {
            // throw new \DomainException("Data dengan ID {$id} tidak ditemukan.");
            throw new \DomainException("Data dengan tidak ditemukan.");
        }

        $model->delete();

        return $model;
    }

    /**
     * Hard delete (force delete) record berdasarkan ID, termasuk yang sudah soft deleted
     *
     * @param int|string $id
     * @return Model|null Model sebelum dihapus, atau null kalau tidak ditemukan
     *
     * @throws \DomainException Jika data tidak ditemukan
     */
    public function buildForceDelete(int|string $id): ?Model
    {
        $modelClass = $this->getModelClass();

        $model = $modelClass::withTrashed()->find($id);

        if (!$model) {
            // throw new \DomainException("Data dengan ID {$id} tidak ditemukan.");
            throw new \DomainException("Data dengan tidak ditemukan.");
        }

        $model->forceDelete();

        return $model;
    }

    /**
     * Restore record yang sudah di-soft delete berdasarkan ID
     *
     * @param int|string $id
     * @return Model|null Model yang sudah direstore, atau null kalau tidak ditemukan
     *
     * @throws \DomainException Jika data tidak ditemukan atau belum dihapus
     */
    public function buildRestore(int|string $id): ?Model
    {
        $modelClass = $this->getModelClass();

        // Cari data termasuk yang sudah dihapus (soft deleted)
        $model = $modelClass::withTrashed()->find($id);

        if (!$model) {
            // throw new \DomainException("Data dengan ID {$id} tidak ditemukan, atau sudah dihapus permanen.");
            throw new \DomainException("Data tidak ditemukan, atau sudah dihapus permanen.");
        }

        if (!$model->trashed()) {
            // throw new \DomainException("Data dengan ID {$id} belum dihapus, tidak perlu restore.");
            throw new \DomainException("Data belum dihapus, tidak perlu restore.");
        }

        $model->restore();

        return $model;
    }
}
