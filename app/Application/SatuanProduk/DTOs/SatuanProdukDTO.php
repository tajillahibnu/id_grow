<?php

namespace App\Application\SatuanProduk\DTOs;

use App\Application\DTOs\BaseDTO;
use App\Infrastructure\Persistence\Eloquent\Models\SatuanProduk;

class SatuanProdukDTO extends BaseDTO
{
    public function __construct(
        public ?string $id,
        public array $data
    ) {
        $this->model = new SatuanProduk();
        parent::__construct($id, $data);
    }
}
