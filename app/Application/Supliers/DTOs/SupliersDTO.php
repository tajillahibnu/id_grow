<?php

namespace App\Application\Supliers\DTOs;

use App\Application\DTOs\BaseDTO;
use App\Infrastructure\Persistence\Eloquent\Models\Supliers;

class SupliersDTO extends BaseDTO
{
    public function __construct(
        public ?string $id,
        public array $data
    ) {
        $this->model = new Supliers();
        parent::__construct($id, $data);
    }
}
