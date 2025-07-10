<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\ProdukLokasi\Repositories\ProdukLokasiRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\ProdukLokasi;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EloquentProdukLokasiiRepository extends EloquentBaseRepository implements ProdukLokasiRepositoryInterface
{
    protected function getModelClass(): string
    {
        return ProdukLokasi::class;
    }
    public function validateTersediaDanCukup(int $produkId, int $lokasiId, int $jumlah): ?array
    {
        $produkLokasi = DB::table('view_produk_lokasi')
            ->where('produk_id', $produkId)
            ->where('lokasi_id', $lokasiId)
            ->first();


        if (!$produkLokasi) {
            throw new \Exception("Produk tidak tersedia di lokasi");
        }

        if ($produkLokasi->stok < $jumlah) {
            throw new \Exception("Stok produk tidak mencukupi. Tersedia: {$produkLokasi->stok}, diminta: {$jumlah}.");
        }

        return (array) $produkLokasi;
    }
}
