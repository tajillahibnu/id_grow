<?php

namespace App\Infrastructure\Providers;

use App\Domain\SatuanProduk\Repositories\SatuanProdukRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Repositories\EloquentSatuanProdukRepository;
use Illuminate\Support\ServiceProvider;

class SatuanProdukServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            SatuanProdukRepositoryInterface::class,
            EloquentSatuanProdukRepository::class
        );
    }
}
