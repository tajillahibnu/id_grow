<?php

namespace App\Infrastructure\Providers;

use App\Domain\Produk\Repositories\ProdukRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Repositories\EloquentProdukRepository;
use Illuminate\Support\ServiceProvider;

class ProdukServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            ProdukRepositoryInterface::class,
            EloquentProdukRepository::class
        );
    }
}
