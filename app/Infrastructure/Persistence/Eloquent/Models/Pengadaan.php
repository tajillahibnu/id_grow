<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class Pengadaan extends Model
{
    protected $fillable = [
        'kode_pengadaan',
        'suplier_id',
        'user_id',
        'tanggal_pengadaan',
        'status',
        'catatan',
    ];

    public function suplier()
    {
        return $this->belongsTo(Supliers::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(PengadaanDetail::class);
    }
}
