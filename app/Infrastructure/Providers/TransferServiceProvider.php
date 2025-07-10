<?php

namespace App\Infrastructure\Providers;

use App\Domain\Mutasi\Repositories\MutasiRepositoryInterface;
use App\Domain\Produk\Repositories\ProdukRepositoryInterface;
use App\Domain\Transfer\Repositories\TransferRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Repositories\EloquentMutasiRepository;
use App\Infrastructure\Persistence\Eloquent\Repositories\EloquentProdukRepository;
use App\Infrastructure\Persistence\Eloquent\Repositories\EloquentTransferRepository;
use Illuminate\Support\ServiceProvider;

class TransferServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            TransferRepositoryInterface::class,
            EloquentTransferRepository::class,
        );
    }
}
