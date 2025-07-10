<?php

namespace App\Application\User\DTOs;

use App\Application\DTOs\BaseDTO;
use App\Domain\User\Services\UserService;
use App\Infrastructure\Persistence\Eloquent\Models\User;
use Illuminate\Http\Request;

class UserDTO extends BaseDTO
{
    public function __construct(
        public ?string $id,
        public array $data,
    ) {
        $this->model = new User();
        parent::__construct($id, $data);
    }
}
