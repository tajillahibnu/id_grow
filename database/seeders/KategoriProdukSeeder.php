<?php

namespace Database\Seeders;

use App\Infrastructure\Persistence\Eloquent\Models\KategoriProduk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoriProduks = [
            ['kode' => 'ELEC', 'name' => 'Elektronik'],
            ['kode' => 'FASH', 'name' => 'Fashion'],
            ['kode' => 'FOOD', 'name' => 'Makanan & Minuman'],
            ['kode' => 'BOOK', 'name' => 'Buku'],
            ['kode' => 'HOME', 'name' => 'Peralatan Rumah'],
        ];

        foreach ($kategoriProduks as $kategori) {
            KategoriProduk::create([
                'kode' => $kategori['kode'],
                'name' => $kategori['name'],
            ]);
        }
    }
}
