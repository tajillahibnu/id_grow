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
        DB::statement("DROP VIEW IF EXISTS view_mutasi");
        DB::statement("
            CREATE VIEW view_mutasi AS
            SELECT
                mutasis.id,
                mutasis.produk_lokasi_id,
                mutasis.user_id,
                mutasis.jenis_mutasi_id,
                mutasis.jumlah,
                mutasis.tanggal,
                mutasis.keterangan,
                mutasis.created_at,
                mutasis.updated_at,
                jenis_mutasis.kode,
                jenis_mutasis.name AS mutasi_name,
                produk_lokasis.produk_id,
                produk_lokasis.lokasi_id,
                produks.name AS produk_name,
                lokasis.name AS lokasi_name,
                jenis_mutasis.efek_stok
            FROM
                mutasis
                INNER JOIN jenis_mutasis ON mutasis.jenis_mutasi_id = jenis_mutasis.id
                INNER JOIN produk_lokasis ON mutasis.produk_lokasi_id = produk_lokasis.id
                INNER JOIN produks ON produk_lokasis.produk_id = produks.id
                INNER JOIN lokasis ON produk_lokasis.lokasi_id = lokasis.id
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS view_mutasi");
    }
};
