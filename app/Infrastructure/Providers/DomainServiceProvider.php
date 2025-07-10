<?php

namespace App\Infrastructure\Providers;

use App\Domain\Mutasi\Repositories\MutasiRepositoryInterface;
use App\Domain\Produk\Repositories\ProdukRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Repositories\EloquentMutasiRepository;
use App\Infrastructure\Persistence\Eloquent\Repositories\EloquentProdukRepository;
use App\Infrastructure\Services\IdEncoder;
use Illuminate\Support\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind IdEncoder ke container dengan inject key dari env
        $this->app->singleton(IdEncoder::class, function ($app) {
            $key = env('ID_ENC_KEY', '1234567890abcdef'); // kunci rahasia dari .env
            return new IdEncoder($key);
        });
        $this->app->register(LokasiServiceProvider::class);
        $this->app->register(KategoriProdukServiceProvider::class);
        $this->app->register(SatuanProdukServiceProvider::class);
        $this->app->register(JenisMutasiServiceProvider::class);
        $this->app->register(TransferServiceProvider::class);
        $this->app->register(ProdukLokasiServiceProvider::class);
        $this->app->register(ProdukSerialServiceProvider::class);
                $this->app->register(UserServiceProvider::class);
                $this->app->register(SupliersServiceProvider::class);
        // add new serviceprovider
        $this->app->bind(ProdukRepositoryInterface::class, EloquentProdukRepository::class);
        $this->app->bind(MutasiRepositoryInterface::class, EloquentMutasiRepository::class);
    }
}
