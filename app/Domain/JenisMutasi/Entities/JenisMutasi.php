<?php

namespace App\Domain\JenisMutasi\Entities;

use App\Domain\Entities\BaseEntity;

class JenisMutasi extends BaseEntity
{
    public ?string $id = null;
        public ?string $kode;
    public ?string $name;
    public ?string $efek_stok;
    public ?string $aktif;
    // public ?string $name;
    // public ?bool $is_aktif = false;
}
