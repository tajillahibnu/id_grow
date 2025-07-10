<?php

namespace App\Domain\Supliers\Entities;

use App\Domain\Entities\BaseEntity;

class Supliers extends BaseEntity
{
    public ?string $id = null;
    public ?string $kode;
    public ?string $nama;
    public ?string $kontak;
    public ?string $email;
    public ?string $alamat;
    public ?string $catatan;
}
