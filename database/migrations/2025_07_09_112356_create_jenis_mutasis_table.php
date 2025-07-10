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
        Schema::create('jenis_mutasis', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('name');
            $table->enum('efek_stok', ['tambah', 'kurang', 'netral'])->default('netral');
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_mutasis');
    }
};
