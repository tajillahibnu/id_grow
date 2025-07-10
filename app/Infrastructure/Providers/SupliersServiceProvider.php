<?php

namespace App\Infrastructure\Providers;

use App\Domain\Supliers\Repositories\SupliersRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Repositories\EloquentSupliersRepository;
use Illuminate\Support\ServiceProvider;

class SupliersServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            SupliersRepositoryInterface::class,
            EloquentSupliersRepository::class
        );
    }
}
