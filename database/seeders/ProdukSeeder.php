<?php

namespace Database\Seeders;

use App\Infrastructure\Persistence\Eloquent\Models\KategoriProduk;
use App\Infrastructure\Persistence\Eloquent\Models\Produk;
use App\Infrastructure\Persistence\Eloquent\Models\SatuanProduk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua kategori dan satuan dalam array associative berdasarkan kode supaya mudah referensi
        $kategoriMap = KategoriProduk::all()->keyBy('kode');
        $satuanMap = SatuanProduk::all()->keyBy('kode');

        $produks = [
            // Elektronik
            [
                'kode' => 'ELEC001',
                'name' => 'Smartphone XYZ',
                'kategori_kode' => 'ELEC',
                'satuan_kode' => 'PCS',
                'deskripsi' => 'Smartphone dengan layar 6.5 inch dan kamera 48MP.',
            ],
            [
                'kode' => 'ELEC002',
                'name' => 'LED TV 42 inch',
                'kategori_kode' => 'ELEC',
                'satuan_kode' => 'UNIT',
                'deskripsi' => 'Televisi LED dengan resolusi Full HD.',
            ],

            // Fashion
            [
                'kode' => 'FASH001',
                'name' => 'Kaos Polos Putih',
                'kategori_kode' => 'FASH',
                'satuan_kode' => 'PCS',
                'deskripsi' => 'Kaos polos warna putih bahan katun premium.',
            ],
            [
                'kode' => 'FASH002',
                'name' => 'Celana Jeans Biru',
                'kategori_kode' => 'FASH',
                'satuan_kode' => 'PCS',
                'deskripsi' => 'Celana jeans warna biru model slim fit.',
            ],

            // Makanan & Minuman
            [
                'kode' => 'FOOD001',
                'name' => 'Minyak Goreng 1 Liter',
                'kategori_kode' => 'FOOD',
                'satuan_kode' => 'LTR',
                'deskripsi' => 'Minyak goreng kemasan 1 liter.',
            ],
            [
                'kode' => 'FOOD002',
                'name' => 'Gula Pasir 1 Kg',
                'kategori_kode' => 'FOOD',
                'satuan_kode' => 'KG',
                'deskripsi' => 'Gula pasir berkualitas tinggi kemasan 1 kilogram.',
            ],
            [
                'kode' => 'FOOD003',
                'name' => 'Air Mineral 600ml',
                'kategori_kode' => 'FOOD',
                'satuan_kode' => 'ML',
                'deskripsi' => 'Air mineral kemasan botol 600ml.',
            ],

            // Buku
            [
                'kode' => 'BOOK001',
                'name' => 'Buku Matematika Dasar',
                'kategori_kode' => 'BOOK',
                'satuan_kode' => 'LBR',
                'deskripsi' => 'Buku pelajaran matematika tingkat SMA.',
            ],
            [
                'kode' => 'BOOK002',
                'name' => 'Novel Fiksi Populer',
                'kategori_kode' => 'BOOK',
                'satuan_kode' => 'PCS',
                'deskripsi' => 'Novel fiksi terbaru dari penulis ternama.',
            ],

            // Peralatan Rumah
            [
                'kode' => 'HOME001',
                'name' => 'Set Alat Masak',
                'kategori_kode' => 'HOME',
                'satuan_kode' => 'SET',
                'deskripsi' => 'Set alat masak lengkap untuk dapur modern.',
            ],
            [
                'kode' => 'HOME002',
                'name' => 'Lampu Meja LED',
                'kategori_kode' => 'HOME',
                'satuan_kode' => 'PCS',
                'deskripsi' => 'Lampu meja LED hemat energi dengan desain minimalis.',
            ],
        ];

        foreach ($produks as $data) {
            Produk::create([
                'kode' => $data['kode'],
                'name' => $data['name'],
                'kategori_produk_id' => $kategoriMap[$data['kategori_kode']]->id ?? null,
                'satuan_produk_id' => $satuanMap[$data['satuan_kode']]->id ?? null,
                'deskripsi' => $data['deskripsi'] ?? null,
            ]);
        }
    }
}
