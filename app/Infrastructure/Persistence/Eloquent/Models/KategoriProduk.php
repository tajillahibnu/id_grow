<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KategoriProduk extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kode',
        'name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function produks()
    {
        return $this->hasMany(Produk::class, 'kategori_produk_id');
    }
}
