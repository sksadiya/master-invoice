<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the super-admin role
        $superAdminRole = Role::create(['name' => 'Super Admin']);

        // Get all permissions
        $permissions = Permission::all();

        // Assign all permissions to the super-admin role
        $superAdminRole->syncPermissions($permissions);
    }
}
