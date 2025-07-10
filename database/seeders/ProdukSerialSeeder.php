<?php

namespace Database\Seeders;

use App\Infrastructure\Persistence\Eloquent\Models\ProdukLokasi;
use App\Infrastructure\Persistence\Eloquent\Models\ProdukSerial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ProdukSerialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua produk_lokasis
        $produkLokasis = ProdukLokasi::with('produk', 'lokasi')->get();

        foreach ($produkLokasis as $pl) {
            // Hanya buat serial jika stok > 0
            if ($pl->stok > 0) {
                for ($i = 1; $i <= $pl->stok; $i++) {
                    ProdukSerial::create([
                        'produk_id'         => $pl->produk_id,
                        'lokasi_id'         => $pl->lokasi_id,
                        'serial_number'     => strtoupper(Str::uuid()),
                        'barcode'           => 'BR-' . strtoupper(Str::random(8)),
                        'batch_number'      => 'BATCH-' . rand(1000, 9999),
                        'tanggal_produksi'  => Carbon::now()->subDays(rand(10, 100)),
                        'expired_at'        => Carbon::now()->addMonths(rand(6, 24)),
                        'garansi_sampai'    => Carbon::now()->addMonths(rand(12, 36)),
                        'status'            => 'tersedia',
                        'keterangan'        => 'Generated via stok seeder',
                    ]);
                }
            }
        }
    }
}
