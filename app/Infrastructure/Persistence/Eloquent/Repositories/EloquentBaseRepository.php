<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Traits\CrudBasicEloquentTrait;
use App\Traits\IdCodec;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of Model
 * @template TEntity
 */
abstract class EloquentBaseRepository
{
    use IdCodec;
    use CrudBasicEloquentTrait;
    /**
     * Return nama class model Eloquent (misal: App\Infrastructure\Persistence\Eloquent\Models\Pegawai)
     * @return class-string<TModel>
     */
    abstract protected function getModelClass(): string;
}
