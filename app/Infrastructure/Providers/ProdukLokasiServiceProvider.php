<?php

namespace App\Infrastructure\Providers;

use App\Domain\ProdukLokasi\Repositories\ProdukLokasiRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Repositories\EloquentProdukLokasiiRepository;
use Illuminate\Support\ServiceProvider;

class ProdukLokasiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            ProdukLokasiRepositoryInterface::class,
            EloquentProdukLokasiiRepository::class
        );
    }
}
