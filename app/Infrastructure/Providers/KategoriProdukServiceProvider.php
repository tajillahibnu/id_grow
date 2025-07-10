<?php

namespace App\Infrastructure\Providers;

use App\Domain\KategoriProduk\Repositories\KategoriProdukRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Repositories\EloquentKategoriProdukRepository;
use Illuminate\Support\ServiceProvider;

class KategoriProdukServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            KategoriProdukRepositoryInterface::class,
            EloquentKategoriProdukRepository::class
        );
    }
}
