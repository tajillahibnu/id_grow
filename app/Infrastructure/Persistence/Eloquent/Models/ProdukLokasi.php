<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukLokasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id',
        'lokasi_id',
        'stok',
        'min_stok',
        'harga_eceran',
        'min_eceran',
        'harga_grosir',
        'min_grosir',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    // public function mutasis()
    // {
    //     return $this->hasMany(Mutasi::class);
    // }
}
