<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lokasi extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kode',
        'name',
        'alamat',
        'kontak',
    ];


    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function produk()
    {
        return $this->belongsToMany(Produk::class, 'produk_lokasis')
            ->withPivot('stok')
            ->withTimestamps();
    }
}
