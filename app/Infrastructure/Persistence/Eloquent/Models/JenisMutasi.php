<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class JenisMutasi extends Model
{
    protected $fillable = [
        'kode',
        'name',
        'efek_stok',
        'aktif'
    ];

    public static function kode(string $kode): int
    {
        return self::where('kode', $kode)->value('id');
    }


    public function mutasis()
    {
        return $this->hasMany(Mutasi::class);
    }
}
