<?php

namespace App\Domain\Transfer\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class KodeTransferService
{
    public function generateKode(): string
    {
        $prefix = 'TRX';
        $date = now()->format('Ymd');

        // Ambil nomor urut hari ini
        $lastKode = DB::table('transfers')
            ->whereDate('created_at', now())
            ->where('kode_transfer', 'like', "$prefix-$date%")
            ->orderByDesc('id')
            ->value('kode_transfer');

        $lastNumber = 0;

        if ($lastKode) {
            $lastNumber = (int) substr($lastKode, -4);
        }

        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        return "{$prefix}-{$date}-{$newNumber}";
    }
}
