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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transfer')->index();
            $table->foreignId('parent_id')->nullable()->constrained('transfers')->nullOnDelete();
            $table->foreignId('lokasi_id')->constrained('lokasis')->onDelete('restrict');
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            
            $table->enum('tipe_transaksi', ['permintaan_transfer', 'transfer_keluar', 'transfer_masuk']);

            $table->date('tanggal');
            $table->enum('status', ['draft', 'diminta', 'disetujui', 'dikirim','ditrima', 'selesai', 'dibatalkan','hide'])->default('draft');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        // Schema::create('transfers', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('kode_transfer')->unique();
        //     $table->foreignId('lokasi_asal_id')->constrained('lokasis')->onDelete('restrict');
        //     $table->foreignId('lokasi_tujuan_id')->constrained('lokasis')->onDelete('restrict');
        //     $table->foreignId('user_pengirim_id')->constrained('users')->onDelete('restrict');
        //     $table->foreignId('user_penerima_id')->nullable()->constrained('users')->onDelete('restrict');
        //     $table->date('tanggal_kirim');
        //     $table->date('tanggal_terima')->nullable();
        //     $table->enum('status', ['draft', 'dikirim', 'diterima', 'dibatalkan'])->default('draft');
        //     $table->text('catatan')->nullable();
        //     $table->integer('durasi_hari')->nullable();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
