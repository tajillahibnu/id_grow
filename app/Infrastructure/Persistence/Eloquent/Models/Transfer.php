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

    // 🔁 Parent Transfer (permintaan atau pengiriman)
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    // 🔁 Children Transfers (transfer keluar / masuk dari permintaan)
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    // 📦 Lokasi yang melakukan transfer
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    // 👤 User yang membuat transfer ini
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 📄 Detail produk pada transfer ini
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
