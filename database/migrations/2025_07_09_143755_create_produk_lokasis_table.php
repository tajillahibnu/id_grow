<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produk_lokasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
            $table->foreignId('lokasi_id')->constrained('lokasis')->onDelete('cascade');
            $table->integer('stok')->default(0);
            $table->integer('min_stok')->default(0);

            $table->decimal('harga_eceran', 16, 2)->nullable();       // Harga satuan kecil
            $table->unsignedInteger('min_eceran')->default(1);

            $table->decimal('harga_grosir', 16, 2)->nullable();       // Harga grosir (biasanya lebih murah)
            $table->unsignedInteger('min_grosir')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_lokasis');
    }
};
