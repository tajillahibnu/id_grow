<?php

namespace Database\Seeders;

use App\Infrastructure\Persistence\Eloquent\Models\AppPermission;
use App\Infrastructure\Persistence\Eloquent\Models\AppRoles;
use App\Infrastructure\Persistence\Eloquent\Models\KategoriProduk;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            AppRolesSeeder::class,
            AppMenuSeeder::class,
            LokasiSeeder::class,
            SatuanProdukSeeder::class,
            KategoriProdukSeeder::class,
            JenisMutasiSeeder::class,
        ]);
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'super@example.com',
            'primary_role_id' => 1,
            'lokasi_id' => 1,
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'primary_role_id' => 5,
            'lokasi_id' => 1,
        ]);

        $this->call([
            ProdukSeeder::class,
            ProdukLokasiSeeder::class,
            ProdukSerialSeeder::class,
        ]);


        // Ambil user superadmin dan staf
        $superadmin = User::where('email', 'super@example.com')->first();
        $staffUser = User::where('email', 'user@example.com')->first();

        $roleIds = AppRoles::pluck('id')->all();

        // Attach semua role ke superadmin dengan pivot is_primary true pada primary_role_id
        $rolesWithPivotSuperadmin = [];
        foreach ($roleIds as $roleId) {
            $rolesWithPivotSuperadmin[$roleId] = [
                'is_primary' => ($superadmin->primary_role_id == $roleId),
            ];
        }
        $superadmin->roles()->sync($rolesWithPivotSuperadmin);
        $this->command->info('Superadmin assigned all roles.');

        // Attach hanya satu role ke staf sesuai primary_role_id, is_primary = true
        if ($staffUser && in_array($staffUser->primary_role_id, $roleIds)) {
            $staffUser->roles()->sync([
                $staffUser->primary_role_id => ['is_primary' => true]
            ]);
            $this->command->info('Staff user assigned primary role only.');
        }
    }
}
