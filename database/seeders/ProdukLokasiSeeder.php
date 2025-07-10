<?php

namespace Database\Seeders;

use App\Infrastructure\Persistence\Eloquent\Models\Lokasi;
use App\Infrastructure\Persistence\Eloquent\Models\Produk;
use App\Infrastructure\Persistence\Eloquent\Models\ProdukLokasi;
use Illuminate\Database\Seeder;

class ProdukLokasiSeeder extends Seeder
{
    public function run(): void
    {
        $produks = Produk::all();
        $lokasiIds = Lokasi::pluck('id')->toArray();

        foreach ($produks as $produk) {
            $randomLokasiId = $lokasiIds[array_rand($lokasiIds)];

            ProdukLokasi::create([
                'produk_id'      => $produk->id,
                'lokasi_id'      => $randomLokasiId,
                'stok'           => rand(5, 50),
                'min_stok'       => rand(1, 5),
                'harga_eceran'   => $produk->harga_jual,
                'min_eceran'     => 1,
                'harga_grosir'   => $produk->harga_jual * 0.85,
                'min_grosir'     => 10,
            ]);
        }

        // Khusus produk 1-3 di lokasi 1 dan 2
        for ($i = 1; $i <= 3; $i++) {
            $produk = Produk::find($i);
            if (!$produk) continue;

            foreach ([1, 2] as $lokasiId) {
                ProdukLokasi::updateOrCreate(
                    [
                        'produk_id' => $produk->id,
                        'lokasi_id' => $lokasiId,
                    ],
                    [
                        'stok'           => 50,
                        'min_stok'       => 2,
                        'harga_eceran'   => $produk->harga_jual,
                        'min_eceran'     => 1,
                        'harga_grosir'   => $produk->harga_jual * 0.85,
                        'min_grosir'     => 10,
                    ]
                );
            }
        }
    }
}
