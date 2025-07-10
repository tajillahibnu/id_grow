<?php

namespace App\Infrastructure\Providers;

use App\Domain\ProdukSerial\Repositories\ProdukSerialRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Repositories\EloquentProdukSerialRepository;
use Illuminate\Support\ServiceProvider;

class ProdukSerialServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            ProdukSerialRepositoryInterface::class,
            EloquentProdukSerialRepository::class
        );
    }
}
