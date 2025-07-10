<?php

namespace App\Application\User\UseCase;

use App\Application\User\DTOs\RegisterUserDTO;
use App\Domain\User\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class RegisterUserAction
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function execute(RegisterUserDTO $dto)
    {
        return $this->userRepository->create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => Hash::make($dto->password),
        ]);
    }
}
