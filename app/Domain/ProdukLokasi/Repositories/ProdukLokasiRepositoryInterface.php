<?php

namespace App\Domain\ProdukLokasi\Repositories;

interface ProdukLokasiRepositoryInterface
{
    public function validateTersediaDanCukup(int $produkId, int $lokasiId, int $jumlah): ?array;
}
