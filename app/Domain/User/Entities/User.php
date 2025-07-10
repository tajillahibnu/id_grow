<?php

namespace App\Domain\User\Entities;

use App\Domain\Entities\BaseEntity;

class User extends BaseEntity
{
    public ?string $id = null;
        public ?string $name;
    public ?string $email;
    public ?string $password;
    // public ?string $name;
    // public ?bool $is_aktif = false;
}
