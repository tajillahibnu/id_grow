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
        Schema::create('log_logins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('ip_address', 45)->nullable(); // Support IPv6
            $table->string('user_agent')->nullable();
            $table->string('device')->nullable(); // Optional: browser/device info
            $table->string('os')->nullable(); // 👈 Tambahan
            $table->string('deskripsi')->nullable(); // 👈 manual, auto, force
            $table->enum('log_type', ['login', 'logout']); // 👈 tipe log
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_logins');
    }
};
