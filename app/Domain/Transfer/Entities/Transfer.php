<?php

namespace App\Domain\Transfer\Entities;

use App\Domain\Entities\BaseEntity;

class Transfer extends BaseEntity
{
    public ?string $id = null;
    public ?string $kode_transfer;
    public ?int $lokasi_id = null;
    public ?int $parent_id;
    public ?string $tanggal;
    public ?string $tipe_transaksi;
    public ?string $status;
    public ?string $catatan;
    public ?string $user_id;
    // public ?string $name;
    // public ?bool $is_aktif = false;
}
