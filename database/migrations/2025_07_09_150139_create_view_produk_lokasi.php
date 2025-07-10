<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("DROP VIEW IF EXISTS view_produk_lokasi");
        DB::statement("
            CREATE VIEW view_produk_lokasi AS
            SELECT
                produk_lokasis.id,
                produk_lokasis.produk_id,
                produk_lokasis.lokasi_id,
                produk_lokasis.stok,
                produk_lokasis.min_stok,
                produks.kode,
                produks.name,
                produks.deskripsi,
                lokasis.name AS lokasi,
                lokasis.alamat,
                lokasis.kontak
            FROM
                produk_lokasis
                INNER JOIN produks ON produk_lokasis.produk_id = produks.id
                INNER JOIN lokasis ON produk_lokasis.lokasi_id = lokasis.id
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_produk_lokasi');
    }
};
