<?php

namespace App\Application\ProdukSerial\DTOs;

use App\Application\DTOs\BaseDTO;
use App\Infrastructure\Persistence\Eloquent\Models\ProdukSerial;

class ProdukSerialDTO extends BaseDTO
{
    public function __construct(
        public ?string $id,
        public array $data
    ) {
        $this->model = new ProdukSerial();
        parent::__construct($id, $data);
    }
}
