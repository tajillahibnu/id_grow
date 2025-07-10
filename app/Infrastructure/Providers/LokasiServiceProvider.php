<?php

namespace App\Infrastructure\Providers;

use App\Domain\Lokasi\Repositories\LokasiRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Repositories\EloquentLokasiRepository;
use Illuminate\Support\ServiceProvider;

class LokasiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            LokasiRepositoryInterface::class,
            EloquentLokasiRepository::class
        );
    }
}
