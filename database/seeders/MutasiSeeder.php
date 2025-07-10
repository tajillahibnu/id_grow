<?php

namespace Database\Seeders;

use App\Infrastructure\Persistence\Eloquent\Models\JenisMutasi;
use App\Infrastructure\Persistence\Eloquent\Models\Mutasi;
use App\Infrastructure\Persistence\Eloquent\Models\ProdukLokasi;
use App\Infrastructure\Persistence\Eloquent\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class MutasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $produkLokasi = ProdukLokasi::first(); // pastikan sudah ada data
        $user = User::first(); // pastikan sudah ada user
        $jenisMutasiMasuk = JenisMutasi::where('kode', 'masuk')->first();
        $jenisMutasiKeluar = JenisMutasi::where('kode', 'keluar')->first();

        if (!$produkLokasi || !$user || !$jenisMutasiMasuk || !$jenisMutasiKeluar) {
            return; // skip seeder jika relasi belum ada
        }

        Mutasi::create([
            'produk_lokasi_id' => $produkLokasi->id,
            'user_id' => $user->id,
            'jenis_mutasi_id' => $jenisMutasiMasuk->id,
            'jumlah' => 50,
            'tanggal' => Carbon::now()->subDays(3),
            'keterangan' => 'Barang masuk awal',
        ]);

        Mutasi::create([
            'produk_lokasi_id' => $produkLokasi->id,
            'user_id' => $user->id,
            'jenis_mutasi_id' => $jenisMutasiKeluar->id,
            'jumlah' => 10,
            'tanggal' => Carbon::now()->subDays(1),
            'keterangan' => 'Pengambilan untuk outlet',
        ]);
    }
}
