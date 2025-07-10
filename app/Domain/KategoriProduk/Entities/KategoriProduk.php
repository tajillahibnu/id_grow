<?php

namespace App\Domain\KategoriProduk\Entities;

use App\Domain\Entities\BaseEntity;

class KategoriProduk extends BaseEntity
{
    public ?string $id = null;
        public ?string $kode;
    public ?string $name;
    // public ?string $name;
    // public ?bool $is_aktif = false;
}
