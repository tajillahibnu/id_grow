<?php

namespace App\Application\User\DTOs;

class RegisterUserDTO
{
    public string $name;
    public string $email;
    public string $password;

    public static function fromRequest($request): self
    {
        $dto = new self();
        $dto->name = $request->name;
        $dto->email = $request->email;
        $dto->password = $request->password;

        return $dto;
    }
}
