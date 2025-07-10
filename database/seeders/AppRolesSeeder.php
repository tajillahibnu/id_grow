<?php

namespace Database\Seeders;

use App\Infrastructure\Persistence\Eloquent\Models\AppRoles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'kode' => 'SUPER',
                'slug' => 'superadmin',
                'name' => 'superadmin',
                'description' => 'Akses penuh ke sistem',
            ],
            [
                'kode' => 'ADM',
                'slug' => 'admin',
                'name' => 'Administrator',
                'description' => 'Akses penuh ke sistem gudang',
            ],
            [
                'kode' => 'APP',
                'slug' => 'A000',
                'name' => 'Approver',
                'description' => 'Menyetujui permintaan mutasi dan stok opname',
            ],
            [
                'kode' => 'MGR',
                'slug' => 'M000',
                'name' => 'Manager',
                'description' => 'Mengelola produk dan stok',
            ],
            [
                'kode' => 'STK',
                'slug' => 'S000',
                'name' => 'Petugas Stok',
                'description' => 'Mengelola stok barang',
            ],
            [
                'kode' => 'ADM_GDG',
                'slug' => 'G000',
                'name' => 'Admin Gudang',
                'description' => 'Mengelola barang masuk dan keluar di gudang',
            ],
        ];

        foreach ($roles as $role) {
            AppRoles::updateOrCreate(['slug' => $role['slug']], $role);
        }
    }
}
