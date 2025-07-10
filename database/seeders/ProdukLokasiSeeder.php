<?php

namespace Database\Seeders;

use App\Infrastructure\Persistence\Eloquent\Models\Lokasi;
use App\Infrastructure\Persistence\Eloquent\Models\Produk;
use App\Infrastructure\Persistence\Eloquent\Models\ProdukLokasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukLokasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $produkIds = Produk::pluck('id')->toArray();
        $lokasiIds = Lokasi::pluck('id')->toArray();

        foreach ($produkIds as $produkId) {
            ProdukLokasi::create([
                'produk_id' => $produkId,
                'lokasi_id' => $lokasiIds[array_rand($lokasiIds)],
                'stok' => rand(5, 50),
                'min_stok' => rand(1, 5),
            ]);
        }

        for ($i = 1; $i <= 3; $i++) {
            ProdukLokasi::updateOrCreate(
                [
                    'produk_id' => $i,
                    'lokasi_id' => 1,
                ],
                [
                    'stok' => 50,
                    'min_stok' => 2,
                ]
            );

            ProdukLokasi::updateOrCreate(
                [
                    'produk_id' => $i,
                    'lokasi_id' => 2,
                ],
                [
                    'stok' => 50,
                    'min_stok' => 2,
                ]
            );
        }
    }
}
