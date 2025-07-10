<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Mutasi\Repositories\MutasiRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\Mutasi;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EloquentMutasiRepository implements MutasiRepositoryInterface
{

    public function getHistoryByProdukId(int $produkId): array
    {
        $produk = DB::table('view_produk')
            ->select('id', 'kode', 'name', 'kategori_name', 'satuan_name', 'deskripsi')
            ->where('id', $produkId)
            ->first();

        if (!$produk) {
            throw new \Exception("Produk dengan ID {$produkId} tidak ditemukan.");
        }

        $mutasis = Mutasi::with(['produkLokasi.lokasi', 'jenisMutasi', 'user'])
            ->whereHas('produkLokasi', fn($q) => $q->where('produk_id', $produkId))
            ->orderByDesc('tanggal')
            ->get();

        $histori = $mutasis->map(function ($mutasi) {
            return [
                'tanggal'        => $mutasi->tanggal,
                'jumlah'         => $mutasi->jumlah,
                'keterangan'     => $mutasi->keterangan,
                'jenis'          => $mutasi->jenisMutasi->name ?? null,
                'efek_stok'      => $mutasi->jenisMutasi->efek_stok ?? null,
                'lokasi'         => $mutasi->produkLokasi->lokasi->name ?? null,
                'user'           => $mutasi->user->name ?? null,
                'referensi_kode' => $mutasi->referensi_kode,
            ];
        });

        $produk = (array) $produk;
        $produk['histori_mutasi'] = $histori;

        return [$produk];
    }

    public function getHistoryByUserId(int $userId): array
    {
        $user = DB::table('users')
            ->select('id', 'name', 'email')
            ->where('id', $userId)
            ->first();

        if (!$user) {
            throw new \Exception("User dengan ID {$userId} tidak ditemukan.");
        }

        $mutasis = Mutasi::with(['produkLokasi.produk', 'produkLokasi.lokasi', 'jenisMutasi'])
            ->where('user_id', $userId)
            ->orderByDesc('tanggal')
            ->get();

        $histori = $mutasis->map(function ($mutasi) {
            return [
                'tanggal'        => $mutasi->tanggal,
                'jumlah'         => $mutasi->jumlah,
                'keterangan'     => $mutasi->keterangan,
                'produk'         => $mutasi->produkLokasi->produk->name ?? null,
                'lokasi'         => $mutasi->produkLokasi->lokasi->name ?? null,
                'jenis'          => $mutasi->jenisMutasi->name ?? null,
                'efek_stok'      => $mutasi->jenisMutasi->efek_stok ?? null,
                'referensi_kode' => $mutasi->referensi_kode,
            ];
        });

        $user = (array) $user;
        $user['histori_mutasi'] = $histori;

        return [$user];
    }
}
