<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SalesRoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permission = Permission::create([
            'name' => 'manage_redirect_links',
            'display_name' => 'Manage Redirect Links',
        ]);

        $role = Role::create([
            'name' => 'sales',
            'display_name' => 'Sales',
        ]);

        $role->givePermissionTo($permission);
    }
}
