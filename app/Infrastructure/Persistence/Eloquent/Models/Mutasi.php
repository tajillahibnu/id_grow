<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mutasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_lokasi_id',
        'user_id',
        'jenis_mutasi_id',
        'jumlah',
        'tanggal',
        'keterangan',
        'referensi_kode',
        'mutasi_id',
    ];

    public function produkLokasi()
    {
        return $this->belongsTo(ProdukLokasi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenisMutasi()
    {
        return $this->belongsTo(JenisMutasi::class);
    }

    public function mutasiSerials()
    {
        return $this->hasMany(MutasiSerial::class);
    }
}
