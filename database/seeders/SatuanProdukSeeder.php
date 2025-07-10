<?php

namespace Database\Seeders;

use App\Infrastructure\Persistence\Eloquent\Models\SatuanProduk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SatuanProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $satuanProduks = [
            ['kode' => 'PCS', 'name' => 'Pieces'],         // Umum
            ['kode' => 'BOX', 'name' => 'Box'],            // Elektronik, Fashion
            ['kode' => 'PAK', 'name' => 'Pack'],           // Fashion, Food
            ['kode' => 'LBR', 'name' => 'Lembar'],         // Buku, Fashion
            ['kode' => 'KG',  'name' => 'Kilogram'],       // Food
            ['kode' => 'GR',  'name' => 'Gram'],           // Eceran
            ['kode' => 'LTR', 'name' => 'Liter'],          // Food
            ['kode' => 'ML',  'name' => 'Mililiter'],      // Eceran, minuman
            ['kode' => 'UNIT', 'name' => 'Unit'],          // Elektronik
            ['kode' => 'SET', 'name' => 'Set'],            // Home, Fashion
            ['kode' => 'BTL', 'name' => 'Botol'],          // Food
            ['kode' => 'BKS', 'name' => 'Buku Satuan'],    // Buku
            ['kode' => 'BH',  'name' => 'Buah'],           // Eceran item (buah, sayur, alat kecil)
        ];

        foreach ($satuanProduks as $satuan) {
            SatuanProduk::create([
                'kode' => $satuan['kode'],
                'name' => $satuan['name'],
            ]);
        }
    }
}
