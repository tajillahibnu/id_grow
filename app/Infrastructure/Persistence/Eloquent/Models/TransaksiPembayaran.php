<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaksi_id',
        'metode',
        'jumlah',
        'referensi',
    ];

}
