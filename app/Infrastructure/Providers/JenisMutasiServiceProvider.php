<?php

namespace App\Infrastructure\Providers;

use App\Domain\JenisMutasi\Repositories\JenisMutasiRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Repositories\EloquentJenisMutasiRepository;
use Illuminate\Support\ServiceProvider;

class JenisMutasiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            JenisMutasiRepositoryInterface::class,
            EloquentJenisMutasiRepository::class
        );
    }
}
