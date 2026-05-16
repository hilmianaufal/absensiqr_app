<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'manage_students',
            'manage_prayers',
            'scan_qr',
            'view_reports',
            'close_sessions',
            'manage_users',
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name' => $p]);
        }

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $petugas = Role::firstOrCreate(['name' => 'petugas']);
        $viewer = Role::firstOrCreate(['name' => 'viewer']);

        $admin->syncPermissions($permissions);

        $petugas->syncPermissions([
            'scan_qr',
            'view_reports',
            'close_sessions',
        ]);

        $viewer->syncPermissions([
            'view_reports',
        ]);
    }
}
