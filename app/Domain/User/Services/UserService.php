<?php

namespace App\Domain\User\Services;

use Illuminate\Support\Facades\Hash;

class UserService
{
    public function password($password)
    {
        return Hash::make($password);
    }
}
