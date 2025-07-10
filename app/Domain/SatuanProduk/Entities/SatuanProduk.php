<?php

namespace App\Domain\SatuanProduk\Entities;

use App\Domain\Entities\BaseEntity;

class SatuanProduk extends BaseEntity
{
    public ?string $id = null;
        public ?string $kode;
    public ?string $name;
    // public ?string $name;
    // public ?bool $is_aktif = false;
}
