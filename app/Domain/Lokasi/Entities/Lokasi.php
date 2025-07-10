<?php

namespace App\Domain\Lokasi\Entities;

use App\Domain\Entities\BaseEntity;

class Lokasi extends BaseEntity
{
    public ?string $id = null;
    public ?string $kode;
    public ?string $name;
    public ?string $alamat;
    public ?string $kontak;
}
