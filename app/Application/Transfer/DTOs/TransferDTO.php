<?php

namespace App\Application\Transfer\DTOs;

use App\Application\DTOs\BaseDTO;
use App\Infrastructure\Persistence\Eloquent\Models\Transfer;

class TransferDTO extends BaseDTO
{
    public function __construct(
        public ?string $id,
        public array $data
    ) {
        $this->model = new Transfer();
        parent::__construct($id, $data);
    }
}
