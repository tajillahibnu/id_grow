<?php

namespace App\Domain\ProdukSerial\Entities;

use App\Domain\Entities\BaseEntity;

class ProdukSerial extends BaseEntity
{
    public ?string $id = null;
        public ?int $produk_id = null;
    public ?int $lokasi_id = null;
    public ?string $serial_number;
    public ?string $barcode;
    public ?string $batch_number;
    public ?string $tanggal_produksi;
    public ?string $expired_at;
    public ?string $garansi_sampai;
    public ?string $status;
    public ?int $mutasi_id = null;
    public ?int $user_id = null;
    public ?string $keterangan;
    // public ?string $name;
    // public ?bool $is_aktif = false;
}
