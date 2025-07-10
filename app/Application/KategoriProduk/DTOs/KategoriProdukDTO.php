<?php

namespace App\Application\KategoriProduk\DTOs;

use App\Application\DTOs\BaseDTO;
use App\Infrastructure\Persistence\Eloquent\Models\KategoriProduk;

class KategoriProdukDTO extends BaseDTO
{
    public function __construct(
        public ?string $id,
        public array $data
    ) {
        $this->model = new KategoriProduk();
        parent::__construct($id, $data);
    }
}
