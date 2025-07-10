<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class TransferDetail extends Model
{
    protected $fillable = [
        'transfer_id',
        'produk_id',
        'jumlah',
        'kondisi_diterima',
        'keterangan',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        // 'deleted_at',
    ];

    public function transfer()
    {
        return $this->belongsTo(Transfer::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
