<?php

namespace Database\Seeders;

use App\Infrastructure\Persistence\Eloquent\Models\Supliers;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $supliers = [
            [
                'kode' => 'SUP001',
                'nama' => 'PT. Maju Jaya Abadi',
                'kontak' => '08123456789',
                'email' => 'majujaya@example.com',
                'alamat' => 'Jl. Merdeka No. 123, Jakarta',
                'catatan' => 'Langganan utama untuk barang elektronik.'
            ],
            [
                'kode' => 'SUP002',
                'nama' => 'CV. Sumber Rejeki',
                'kontak' => '08234567890',
                'email' => 'sumberrejeki@example.com',
                'alamat' => 'Jl. Sudirman No. 45, Bandung',
                'catatan' => 'Penyedia bahan baku tekstil.'
            ],
            [
                'kode' => 'SUP003',
                'nama' => 'UD. Toko Murah',
                'kontak' => '08567890123',
                'email' => 'tokomurah@example.com',
                'alamat' => 'Pasar Baru Blok A No. 5, Surabaya',
                'catatan' => null
            ]
        ];

        foreach ($supliers as $suplier) {
            Supliers::create($suplier);
        }
    }
}
