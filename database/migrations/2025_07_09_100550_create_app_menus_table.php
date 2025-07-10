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
        Schema::create('app_menus', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 50)->unique()->nullable();
            $table->string('name', 150);
            $table->string('url', 50)->nullable();
            $table->string('route')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('app_menus')->onDelete('cascade');
            $table->boolean('is_global')->default(false); // menu untuk semua user
            $table->boolean('is_aktif')->default(true);
            $table->integer('level')->nullable(); // Menandakan apakah ini menu utama
            $table->string('tipe', 50)->default('main'); // Jenis menu: 'portal' atau 'admin'
            $table->string('view_path', 150)->nullable();
            $table->string('view_file', 100)->nullable()->default('default');
            $table->string('icon', 50)->nullable()->default('ti-smart-home');
            $table->integer('order')->default(0); // urutan tampilan menu
            $table->timestamps();
        });

        Schema::create('app_menu_role', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('app_menus')->onDelete('cascade');
            $table->foreignId('role_id')->constrained('app_roles')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_menu_role');
        Schema::dropIfExists('app_menus');
    }
};
