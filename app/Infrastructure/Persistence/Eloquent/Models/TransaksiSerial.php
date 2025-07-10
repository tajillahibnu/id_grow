<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiSerial extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaksi_detail_id',
        'produk_serial_id',
        'is_garansi',
        'garansi_mulai',
        'garansi_sampai',
    ];

    protected $casts = [
        'garansi_mulai' => 'date',
        'garansi_sampai' => 'date',
    ];
}
