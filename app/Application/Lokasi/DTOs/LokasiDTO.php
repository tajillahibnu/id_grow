<?php

namespace App\Application\Lokasi\DTOs;

use App\Application\DTOs\BaseDTO;
use App\Infrastructure\Persistence\Eloquent\Models\Lokasi;

class LokasiDTO extends BaseDTO
{
    public function __construct(
        public ?string $id,
        public array $data
    ) {
        $this->model = new Lokasi();
        parent::__construct($id, $data);
    }
}
