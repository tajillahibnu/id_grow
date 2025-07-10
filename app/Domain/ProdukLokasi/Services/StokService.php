<?php

namespace App\Domain\ProdukLokasi\Services;

use App\Infrastructure\Persistence\Eloquent\Models\ProdukLokasi;

class StokService
{
    public function kurangiStok(int $produkId, int $lokasiId, int $jumlah): void
    {
        $produkLokasi = ProdukLokasi::where([
            'produk_id' => $produkId,
            'lokasi_id' => $lokasiId
        ])->firstOrFail();

        if ($produkLokasi->stok < $jumlah) {
            throw new \Exception("Stok tidak cukup");
        }

        $produkLokasi->stok -= $jumlah;
        $produkLokasi->save();
    }

    public function tambahStok(int $produkId, int $lokasiId, int $jumlah): void
    {
        $produkLokasi = ProdukLokasi::firstOrCreate([
            'produk_id' => $produkId,
            'lokasi_id' => $lokasiId
        ]);

        $produkLokasi->stok += $jumlah;
        $produkLokasi->save();
    }
}
