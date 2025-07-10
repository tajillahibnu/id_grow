<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class MutasiSerial extends Model
{
    protected $fillable = [
        'mutasi_id',
        'produk_serial_id',
        'keterangan',
    ];

    public function mutasi()
    {
        return $this->belongsTo(Mutasi::class);
    }

    public function produkSerial()
    {
        return $this->belongsTo(ProdukSerial::class);
    }
}
