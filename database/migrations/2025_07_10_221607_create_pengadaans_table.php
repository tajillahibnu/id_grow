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
        Schema::create('pengadaans', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->foreignId('parent_id')->nullable()->constrained('pengadaans')->nullOnDelete();

            $table->foreignId('suplier_id')->nullable()->constrained('supliers')->nullOnDelete();
            $table->foreignId('lokasi_id')->constrained('lokasis')->onDelete('restrict');
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');

            $table->enum('tipe', ['pengadaan', 'penerimaan'])->default('pengadaan');
            $table->enum('status', ['draft', 'diajukan', 'dipesan', 'diterima', 'selesai', 'retur', 'dibatalkan'])->default('draft');

            $table->date('tanggal');
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('pengadaan_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengadaan_id')->constrained('pengadaans')->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('produks')->onDelete('restrict');

            $table->unsignedInteger('jumlah_dipesan')->default(0);
            $table->unsignedInteger('jumlah_diterima')->default(0);
            $table->unsignedInteger('jumlah_rusak')->default(0);

            $table->decimal('harga_satuan', 15, 2)->default(0);
            $table->decimal('subtotal', 18, 2)->default(0);

            $table->enum('tindakan_rusak', ['retur', 'perbaikan', 'dibuang'])->nullable();
            $table->foreignId('mutasi_id')->nullable()->constrained('mutasis')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengadaan_details');
        Schema::dropIfExists('pengadaans');
    }
};
