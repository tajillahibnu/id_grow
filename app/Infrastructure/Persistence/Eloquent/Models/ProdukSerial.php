<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukSerial extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id',
        'lokasi_id',
        'serial_number',
        'barcode',
        'batch_number',
        'tanggal_produksi',
        'expired_at',
        'garansi_sampai',
        'status',
        'mutasi_id',
        'user_id',
        'keterangan',
    ];

    // Relasi
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    public function mutasi()
    {
        return $this->belongsTo(Mutasi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
