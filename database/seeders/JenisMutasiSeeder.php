<?php

namespace Database\Seeders;

use App\Infrastructure\Persistence\Eloquent\Models\JenisMutasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisMutasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kode' => 'masuk',            'name' => 'Barang Masuk',          'efek_stok' => 'tambah'],
            ['kode' => 'keluar',           'name' => 'Barang Keluar',         'efek_stok' => 'kurang'],
            ['kode' => 'retur_masuk',      'name' => 'Retur dari Customer',   'efek_stok' => 'tambah'],
            ['kode' => 'retur_keluar',     'name' => 'Retur ke Supplier',     'efek_stok' => 'kurang'],
            ['kode' => 'transfer_masuk',   'name' => 'Transfer Masuk',        'efek_stok' => 'tambah'],
            ['kode' => 'transfer_keluar',  'name' => 'Transfer Keluar',       'efek_stok' => 'kurang'],
            ['kode' => 'penyesuaian_plus', 'name' => 'Penyesuaian (Surplus)', 'efek_stok' => 'tambah'],
            ['kode' => 'penyesuaian_minus','name' => 'Penyesuaian (Minus)',   'efek_stok' => 'kurang'],
            ['kode' => 'rusak',            'name' => 'Barang Rusak',          'efek_stok' => 'kurang'],
            ['kode' => 'hilang',           'name' => 'Barang Hilang',         'efek_stok' => 'kurang'],
            ['kode' => 'produksi_keluar',  'name' => 'Bahan baku keluar dari stok', 'efek_stok' => 'kurang'],
            ['kode' => 'produksi_masuk',   'name' => 'Produk hasil masuk ke stok',  'efek_stok' => 'tambah'],
        ];

        foreach ($data as $item) {
            JenisMutasi::create($item);
        }
    }
}
