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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->unique();
            $table->dateTime('tanggal');
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('lokasi_id')->constrained('lokasis')->onDelete('restrict');
            $table->decimal('total', 16, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::create('transaksi_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->constrained('transaksis')->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('produks')->onDelete('restrict');

            $table->foreignId('mutasi_id')->nullable()->constrained('mutasis')->nullOnDelete();

            $table->integer('jumlah');
            $table->decimal('harga_satuan', 16, 2);
            $table->decimal('subtotal', 16, 2);
            $table->timestamps();
        });

        Schema::create('transaksi_pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->constrained('transaksis')->onDelete('cascade');
            $table->enum('metode', ['tunai', 'transfer', 'qris', 'edc', 'voucher', 'lainnya']);
            $table->decimal('jumlah', 16, 2);
            $table->string('referensi')->nullable();
            $table->timestamps();
        });

        Schema::create('transaksi_serials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_detail_id')->constrained('transaksi_details')->onDelete('cascade');
            $table->foreignId('produk_serial_id')->constrained('produk_serials')->onDelete('cascade');

            $table->boolean('is_garansi')->default(false);
            $table->date('garansi_mulai')->nullable(); 
            $table->date('garansi_sampai')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_pembayarans');
        Schema::dropIfExists('transaksi_details');
        Schema::dropIfExists('transaksis');
    }
};
