<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transaksi',
        'tanggal',
        'user_id',
        'lokasi_id',
        'total',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
    ];
}
