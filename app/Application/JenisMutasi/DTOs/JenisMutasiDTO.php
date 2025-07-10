<?php

namespace App\Application\JenisMutasi\DTOs;

use App\Application\DTOs\BaseDTO;
use App\Infrastructure\Persistence\Eloquent\Models\JenisMutasi;

class JenisMutasiDTO extends BaseDTO
{
    public function __construct(
        public ?string $id,
        public array $data
    ) {
        $this->model = new JenisMutasi();
        parent::__construct($id, $data);
    }
}
