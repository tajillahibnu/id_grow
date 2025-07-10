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
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
            $table->foreignId('lokasi_id')->constrained('lokasis')->onDelete('cascade');

            $table->string('serial_number')->nullable()->index();  // IMEI / Serial
            $table->string('barcode')->nullable()->index();        // EAN/QR/barcode
            $table->string('batch_number')->nullable();            // No batch produksi

            $table->date('tanggal_produksi')->nullable();
            $table->date('expired_at')->nullable();
            $table->date('garansi_sampai')->nullable();            // Untuk barang elektronik

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

            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('mutasi_serials', function (Blueprint $table) {
            $table->id();

            $table->foreignId('mutasi_id')->constrained('mutasis')->onDelete('cascade');
            $table->foreignId('produk_serial_id')->constrained('produk_serials')->onDelete('cascade');

            $table->text('keterangan')->nullable();

            $table->timestamps();
        });

        Schema::create('transfer_serials', function (Blueprint $table) {
            $table->id();

            $table->foreignId('transfer_detail_id')->constrained('transfer_details')->onDelete('cascade');
            $table->foreignId('produk_serial_id')->constrained('produk_serials')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi_serials');
        Schema::dropIfExists('transfer_serials');
        Schema::dropIfExists('produk_serials');
    }
};
