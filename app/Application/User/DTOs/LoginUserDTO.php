<?php

namespace App\Application\User\DTOs;

class LoginUserDTO
{
    public string $email;
    public string $password;

    public static function fromRequest($request): self
    {
        $dto = new self();
        $dto->email = $request->email;
        $dto->password = $request->password;

        return $dto;
    }
}
