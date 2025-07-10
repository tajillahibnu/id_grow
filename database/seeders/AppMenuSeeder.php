<?php

namespace Database\Seeders;

use App\Infrastructure\Persistence\Eloquent\Models\AppMenu;
use App\Infrastructure\Persistence\Eloquent\Models\AppPermission;
use App\Infrastructure\Persistence\Eloquent\Models\AppRoles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $aArrMenu = [
            'master'
        ];

        $menuNumber = 1;
        for ($i = 0; $i < count($aArrMenu); $i++) {
            if (method_exists($this, $aArrMenu[$i])) {
                $this->{$aArrMenu[$i]}($i + 1, $menuNumber);
                $menuNumber++;
                $this->command->info('Excute : ' . $aArrMenu[$i]);
            } else {
                $this->command->info('Gagal : ' . $aArrMenu[$i]);
            }
        }

        $this->assignRoleMenu();
    }

    private function master($id, $menuNumber)
    {
        $dd = 1;
        $save['id']    = $id;
        $save['name']  = 'Master';
        $save['slug']  = 'master';
        $save['url']   = 'master';
        $save['route'] = 'master';
        $save['order'] = $menuNumber;
        $save['level'] = '0';
        AppMenu::create($save);

        $menuNumber = 1;
        $save['id']         = $id . $dd++;
        $save['parent_id']  = $id;
        $save['slug']  = 'kategori_produk';
        $roleMenu = AppMenu::create($save);

        $permissionSlugs = ['store', 'update', 'delete', 'read'];
        $this->actionMenu($roleMenu, $permissionSlugs);

        $save['id']         = $id . $dd++;
        $save['parent_id']  = $id;
        $save['slug']  = 'lokasi';
        $roleMenu = AppMenu::create($save);

        $permissionSlugs = ['store', 'update', 'delete', 'read'];
        $this->actionMenu($roleMenu, $permissionSlugs);

        $save['id']         = $id . $dd++;
        $save['parent_id']  = $id;
        $save['slug']  = 'satuan_produk';
        $roleMenu = AppMenu::create($save);

        $permissionSlugs = ['store', 'update', 'delete', 'read'];
        $this->actionMenu($roleMenu, $permissionSlugs);

        $save['id']         = $id . $dd++;
        $save['parent_id']  = $id;
        $save['slug']  = 'jenis_mutasi';
        $roleMenu = AppMenu::create($save);

        $permissionSlugs = ['store', 'update', 'delete', 'read'];
        $this->actionMenu($roleMenu, $permissionSlugs);

        $save['id']         = $id . $dd++;
        $save['parent_id']  = $id;
        $save['slug']       = 'produk';
        $roleMenu = AppMenu::create($save);

        $permissionSlugs = ['store', 'update', 'delete', 'read'];
        $this->actionMenu($roleMenu, $permissionSlugs);

        $save['id']         = $id . $dd++;
        $save['parent_id']  = $id;
        $save['slug']       = 'user';
        $roleMenu = AppMenu::create($save);

        $permissionSlugs = ['store', 'update', 'delete', 'read'];
        $this->actionMenu($roleMenu, $permissionSlugs);
    }

    private function actionMenu($roleMenu, $permissionSlugs)
    {
        // Buat permission otomatis untuk menu Role Management
        $permissions = [];

        foreach ($permissionSlugs as $slug) {
            $permissions[] = [
                'name' => ucfirst($slug) . ' ' . $roleMenu->name,
                'slug' => "{$slug}_" . $roleMenu->slug,
                'menu_id' => $roleMenu->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        AppPermission::insert($permissions);
    }

    public function assignRoleMenu()
    {
        $aArrRoles = AppRoles::all();
        foreach ($aArrRoles as $role) {
            if (method_exists($this, $role->slug)) {
                $this->{$role->slug}($role);
            } else {
                $this->command->info('Gagal : ' . $role->slug);
            }
        }
    }

    private function superadmin($role)
    {
        $menuIds = AppMenu::all()->pluck('id')->toArray();
        if (!empty($menuIds)) {
            $role->menus()->syncWithoutDetaching($menuIds);
            $role->permissions()->syncWithoutDetaching(AppPermission::pluck('id'));
            $this->command->info('Excute : ' . $role->slug);
        }
    }

    private function S000($role)
    {
        $this->syncPermissionsFromMenusToRole($role, ['kategori_produk', 'lokasi', 'satuan_produk','jenis_mutasi']);
    }

    private function syncPermissionsFromMenusToRole($role, array $menuSlugs)
    {
        // Ambil menu yang slug-nya ada di $menuSlugs
        $menus = AppMenu::whereIn('slug', $menuSlugs)->get();

        if ($menus->isEmpty()) {
            $this->command->info('No menus found with the given slugs.');
            return;
        }

        // Ambil ID menu
        $menuIds = $menus->pluck('id')->toArray();

        // Ambil permission yang terkait dengan menu tersebut (menu_id IN $menuIds)
        $permissions = AppPermission::whereIn('menu_id', $menuIds)->pluck('id')->toArray();

        if (empty($permissions)) {
            $this->command->info('No permissions found related to the selected menus.');
            return;
        }

        // Sinkronisasi permission ke role tanpa menghapus relasi lain (attach baru saja)
        $role->permissions()->syncWithoutDetaching($permissions);

        $this->command->info("Permissions synced to role '{$role->slug}' for menus: " . implode(', ', $menuSlugs));
    }
}
