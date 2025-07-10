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
        DB::statement("DROP VIEW IF EXISTS view_produk");
        DB::statement("
            CREATE VIEW view_produk AS
            SELECT
                produks.id, 
                produks.kode, 
                produks.name, 
                produks.kategori_produk_id, 
                produks.satuan_produk_id, 
                produks.deskripsi, 
                satuan_produks.name AS satuan_name, 
                kategori_produks.name AS kategori_name
            FROM
                produks
            INNER JOIN satuan_produks ON produks.satuan_produk_id = satuan_produks.id
            INNER JOIN kategori_produks ON produks.kategori_produk_id = kategori_produks.id
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS view_produk");
    }
};
