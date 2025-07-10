<?php

namespace App\Application\Mutasi\UseCase;

use App\Domain\Mutasi\Repositories\MutasiRepositoryInterface;
use App\Domain\User\Repositories\UserRepositoryInterface;
use Exception;

class GetMutasiHistoryByUser
{
    public function __construct(
        private UserRepositoryInterface $userRepo,
        private MutasiRepositoryInterface $mutasiRepo,
    ) {}

    public function execute(int $userId): array
    {
        $user = $this->userRepo->getUserById($userId);
        if (!$user) {
            throw new \Exception("User tidak ditemukan");
        }

        return $this->mutasiRepo->getHistoryByUserId($userId);
    }
}

