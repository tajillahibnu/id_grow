<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class TransferSerial extends Model
{
    protected $fillable = [
        'transfer_detail_id',
        'produk_serial_id',
    ];

    public function transferDetail()
    {
        return $this->belongsTo(TransferDetail::class);
    }

    public function produkSerial()
    {
        return $this->belongsTo(ProdukSerial::class);
    }
}
