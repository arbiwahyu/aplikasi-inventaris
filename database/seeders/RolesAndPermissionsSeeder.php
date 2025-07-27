<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat Permissions
        Permission::create(['name' => 'view items']);
        Permission::create(['name' => 'borrow items']);
        Permission::create(['name' => 'manage items']); // Izin untuk CRUD barang
        Permission::create(['name' => 'manage users']); // Izin untuk CRUD user

        // Buat Roles dan berikan permissions yang sudah dibuat

        // Role untuk Siswa
        $roleSiswa = Role::create(['name' => 'Siswa']);
        $roleSiswa->givePermissionTo(['view items', 'borrow items']);

        // Role untuk Guru
        $roleGuru = Role::create(['name' => 'Guru']);
        $roleGuru->givePermissionTo(['view items', 'borrow items']);

        // Role untuk Staff
        $roleStaff = Role::create(['name' => 'Staff']);
        $roleStaff->givePermissionTo(['view items', 'borrow items', 'manage items']);

        // Role untuk Admin
        // Admin bisa melakukan semuanya, kita bisa berikan semua permission
        $roleAdmin = Role::create(['name' => 'Admin']);
        $roleAdmin->givePermissionTo(Permission::all());
    }
}
