<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Transfer\Entities\Transfer as TransferEntity;
use App\Domain\Transfer\Repositories\TransferRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\Transfer;
use App\Infrastructure\Persistence\Eloquent\Models\TransferDetail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EloquentTransferRepository extends EloquentBaseRepository implements TransferRepositoryInterface
{
    protected function getModelClass(): string
    {
        return Transfer::class;
    }

    // ================================== Trasnfer ==================================
    public function getTransferById(int $id, ?string $tipe_transaksi = null): ?array
    {
        $model = $this->buildQuery(function ($q) use ($id, $tipe_transaksi) {
            $q->where('id', $id);

            if ($tipe_transaksi !== null) {
                $q->where('tipe_transaksi', $tipe_transaksi);
            }
        })->first();

        return $model ? $model->toArray() : null;
    }

    public function getTransferByKode(string $kode, ?string $tipe_transaksi = null): ?array
    {
        $model = $this->buildQuery(function ($q) use ($kode, $tipe_transaksi) {
            $q->where('kode_transfer', $kode);

            if ($tipe_transaksi !== null) {
                $q->where('tipe_transaksi', $tipe_transaksi);
            }
        })->first();

        return $model ? $model->toArray() : null;
    }

    public function storeTransfer(TransferEntity $entity): ?array
    {
        $model = $this->buildCreate($entity);
        return $model->toArray();
    }

    public function updateTransfer(int $id, array $entity): ?array
    {
        $model = Transfer::findOrFail($id);
        $model->fill($entity);
        $model->save();
        return $model->toArray();
    }

    // ================================== End Trasnfer ==================================

    // ================================== Trasnfer Detail ==================================

    public function getTransferDetailById(int $id): ?array
    {
        $model = TransferDetail::where('transfer_id', $id)->get();
        return $model ? $model->toArray() : null;
    }

    public function storeTransferDetails(string|int $transferId, array $produkDetails): ?array
    {
        $items = [];
        foreach ($produkDetails as $detail) {
            $created = TransferDetail::create([
                'transfer_id'   => $transferId,
                'produk_id'     => $detail['produk_id'],
                'jumlah'        => $detail['jumlah'],
                'jumlah_baik'   => null,
                'jumlah_rusak'  => null,
            ]);
            $items[] = $created;
        }
        return $items;
    }
    // ================================== End Trasnfer Detail ==================================

    protected function toEntity(Transfer $model): TransferEntity
    {
        $entity = new TransferEntity();

        $entity->id = $this->encodeId($model->id);
        $entity->kode_transfer  = $model->kode_transfer;
        $entity->tipe_transaksi = $model->tipe_transaksi;
        $entity->status         = $model->status;
        $entity->catatan        = $model->catatan;
        return $entity;
    }

    public function fetchTransfer(string|int $limit = 10, int $offset = 0, string $sort = 'asc'): array
    {
        $query = $this->buildQuery(fn($q) => $q->orderBy('id', $sort));

        if ($limit !== 'all') {
            $query->offset($offset)->limit($limit);
        }

        return $query->get()
            ->map(fn($item) => $this->toEntity($item))
            ->toArray();
    }
}
