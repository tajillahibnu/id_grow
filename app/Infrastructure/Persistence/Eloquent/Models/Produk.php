<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kode',
        'name',
        'kategori_produk_id',
        'satuan_produk_id',
        'deskripsi',
        'harga_jual',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        // 'deleted_at',
    ];

    public function satuan()
    {
        return $this->belongsTo(SatuanProduk::class);
    }

    public function lokasi()
    {
        return $this->belongsToMany(Lokasi::class, 'produk_lokasis')
            ->withPivot('stok')
            ->withTimestamps();
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriProduk::class, 'kategori_produk_id');
    }
}
