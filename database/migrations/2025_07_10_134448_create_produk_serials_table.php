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
        Schema::create('produk_serials', function (Blueprint $table) {
            $table->id();

            // Relasi dasar
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
            $table->foreignId('lokasi_id')->constrained('lokasis')->onDelete('cascade');

            // Identifikasi fisik
            $table->string('serial_number')->nullable()->index();  // IMEI / Serial
            $table->string('barcode')->nullable()->index();        // EAN/QR/barcode
            $table->string('batch_number')->nullable();            // No batch produksi

            // Atribut produk universal
            $table->date('tanggal_produksi')->nullable();
            $table->date('expired_at')->nullable();
            $table->date('garansi_sampai')->nullable();            // Untuk barang elektronik

            // Status barang (lebih lengkap)
            $table->enum('status', [
                'tersedia',     // Barang aktif dan siap dipakai/dijual
                'rusak',        // Barang rusak
                'expired',      // Barang kadaluarsa
                'diperbaiki',   // Sedang proses servis
                'terjual',      // Sudah keluar dari stok (mutasi)
                'dikembalikan', // Return dari user/pembeli
                'hilang',       // Barang hilang
                'dihapus',      // Barang secara sistem dihapus
            ])->default('tersedia');

            // Tracking mutasi
            $table->foreignId('mutasi_id')->nullable()->constrained('mutasis')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); // siapa input/scan

            // Deskripsi tambahan
            $table->text('keterangan')->nullable();     // catatan bebas
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_serials');
    }
};
