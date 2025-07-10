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
        Schema::create('app_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);         // e.g., "Create Role"
            $table->string('slug', 150)->unique(); // e.g., "create_role"
            $table->foreignId('menu_id')->nullable()->constrained('app_menus')->onDelete('cascade'); 
            $table->timestamps();
        });

        Schema::create('app_permission_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('app_roles')->onDelete('cascade');
            $table->foreignId('permission_id')->constrained('app_permissions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_permission_roles');
        Schema::dropIfExists('app_permissions');
    }
};
