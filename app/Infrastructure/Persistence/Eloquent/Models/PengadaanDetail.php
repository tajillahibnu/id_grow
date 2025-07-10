<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengadaanDetail extends Model
{
    use HasFactory;

    protected $table = 'pengadaan_details';

    protected $fillable = [
        'pengadaan_id',
        'produk_id',
        'jumlah_dipesan',
        'jumlah_diterima',
        'jumlah_rusak',
        'harga_satuan',
        'subtotal',
        'tindakan_rusak',
        'mutasi_id',
    ];

    public function pengadaan()
    {
        return $this->belongsTo(Pengadaan::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function mutasi()
    {
        return $this->belongsTo(Mutasi::class);
    }
}
