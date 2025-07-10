<?php

namespace App\Application\Produk\DTOs;

use App\Application\DTOs\BaseDTO;
use App\Infrastructure\Persistence\Eloquent\Models\Produk;

class ProdukDTO extends BaseDTO
{
    public function __construct(
        public ?string $id,
        public array $data
    ) {
        $this->model = new Produk();
        parent::__construct($id, $data);
    }
}
