<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'lokasi_id',
        'user_id',
        'tipe_transaksi',
        'kode_transfer',
        'tanggal',
        'status',
        'catatan',
        'durasi_hari',
    ];

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(TransferDetail::class);
    }

    protected $hidden = [
        'created_at',
        'updated_at',
        // 'deleted_at',
    ];
}
