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
        Schema::create('app_roles', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique()->nullable();
            $table->string('slug')->unique();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('primary_role_id')->nullable()->after('id')->constrained('app_roles')->onDelete('set null');
        });

        Schema::create('app_role_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('app_roles')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->boolean('is_primary')->default(false); // Menandakan apakah role ini adalah role utama
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('app_role_users');
        Schema::dropIfExists('app_roles');
    }
};
