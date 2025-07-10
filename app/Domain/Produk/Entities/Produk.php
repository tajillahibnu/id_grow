<?php

namespace App\Domain\Produk\Entities;

use App\Domain\Entities\BaseEntity;

class Produk extends BaseEntity
{
    public ?string $id = null;
    public ?string $kode;
    public ?string $name;
    public ?int $kategori_produk_id = null;
    public ?int $satuan_produk_id = null;
    public ?string $deskripsi;
}
