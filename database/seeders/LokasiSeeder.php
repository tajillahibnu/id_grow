<?php

namespace Database\Seeders;

use App\Infrastructure\Persistence\Eloquent\Models\Lokasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LokasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lokasis = [
            [
                'kode' => 'GUD001',
                'name' => 'Gudang Utama',
                'alamat' => 'Jl. Raya No. 1, Jakarta',
                'kontak' => '021-555555',
            ],
            [
                'kode' => 'TOKO001',
                'name' => 'Toko Cabang A',
                'alamat' => 'Jl. Melati No. 20, Jakarta',
                'kontak' => '021-666666',
            ],
            [
                'kode' => 'TOKO002',
                'name' => 'Toko Cabang B',
                'alamat' => 'Jl. Kenanga No. 15, Surabaya',
                'kontak' => '031-777777',
            ],
            [
                'kode' => 'GUD002',
                'name' => 'Gudang C',
                'alamat' => 'Jl. Cendana No. 10, Bandung',
                'kontak' => '022-888888',
            ],
        ];

        foreach ($lokasis as $lokasi) {
            Lokasi::updateOrCreate(['kode' => $lokasi['kode']], $lokasi);
        }
    }
}
