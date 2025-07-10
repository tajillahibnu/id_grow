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

    public function hitungHargaTotal(int $jumlah, float $hargaEceran, int $minEceran, ?float $hargaGrosir, ?int $minGrosir): float
    {
        if ($hargaGrosir !== null && $minGrosir !== null && $jumlah >= $minGrosir) {
            return $jumlah * $hargaGrosir;
        }

        return $jumlah * $hargaEceran;
    }

    //     $jumlah1 = 5;
    // $total1 = hitungHargaTotal($jumlah1, 10000, 1, 8500, 12);
    // echo "Jumlah: $jumlah1, Total Harga: Rp " . number_format($total1, 0, ',', '.') . "\n";
    // // Output: Jumlah: 5, Total Harga: Rp 50.000

    // $jumlah2 = 15;
    // $total2 = hitungHargaTotal($jumlah2, 10000, 1, 8500, 12);
    // echo "Jumlah: $jumlah2, Total Harga: Rp " . number_format($total2, 0, ',', '.') . "\n";
    // // Output: Jumlah: 15, Total Harga: Rp 127.500
}
