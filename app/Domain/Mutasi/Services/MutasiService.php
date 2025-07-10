<?php

namespace App\Domain\Mutasi\Services;

use App\Infrastructure\Persistence\Eloquent\Models\JenisMutasi;
use App\Infrastructure\Persistence\Eloquent\Models\Mutasi;
use App\Infrastructure\Persistence\Eloquent\Models\ProdukLokasi;
use App\Infrastructure\Persistence\Eloquent\Models\TransferDetail;
use App\Infrastructure\Persistence\Eloquent\Models\Transfer;

class MutasiService
{
    /**
     * Mutasi keluar dari lokasi pengirim (transfer_keluar)
     */
    public function createMutasiKeluar(array $transfer, array $detail): void
    {
        $produkLokasi = ProdukLokasi::where([
            'produk_id' => $detail['produk_id'],
            'lokasi_id' => $transfer['lokasi_id'],
        ])->firstOrFail();

        $mutasi = Mutasi::create([
            'produk_lokasi_id' => $produkLokasi->id,
            'user_id'          => $transfer['user_id'], // user pengirim
            'jenis_mutasi_id'  => JenisMutasi::kode('transfer_keluar'),
            'jumlah'           => $detail['jumlah'],
            'tanggal'          => now(),
            'keterangan'       => 'Transfer keluar',
            'referensi_kode'   => $transfer['kode_transfer'],
        ]);

        TransferDetail::where([
            'transfer_id' => $transfer['id'],
            'produk_id'   => $detail['produk_id'],
            'mutasi_id'   => null
        ])->update(['mutasi_id' => $mutasi->id]);
    }

    /**
     * Mutasi masuk ke lokasi penerima (transfer_masuk)
     */
    public function createMutasiMasuk(array $transfer, array $detail): void
    {
        $produkLokasi = ProdukLokasi::firstOrCreate([
            'produk_id' => $detail['produk_id'],
            'lokasi_id' => $transfer['lokasi_id'],
        ]);

        $mutasi = Mutasi::create([
            'produk_lokasi_id' => $produkLokasi->id,
            'user_id'          => $transfer['user_id'],
            'jenis_mutasi_id'  => JenisMutasi::kode('transfer_masuk'),
            // 'jumlah'           => $detail['jumlah_baik'],
            'jumlah'           => $detail['jumlah'],
            'tanggal'          => now(),
            'keterangan'       => 'Transfer masuk',
            'referensi_kode'   => $transfer['kode_transfer'],
        ]);

        TransferDetail::where([
            'transfer_id' => $transfer['id'],
            'produk_id'   => $detail['produk_id'],
            'mutasi_id'   => null
        ])->update(['mutasi_id' => $mutasi->id]);
    }
}
