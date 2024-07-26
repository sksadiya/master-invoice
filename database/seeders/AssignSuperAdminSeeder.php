<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class AssignSuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find the user with ID 1
        $user = User::find(1);

        if ($user) {
            // Create the super-admin role if it doesn't exist
            $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);

            // Assign all existing permissions to the super-admin role
            $permissions = Permission::all();
            $superAdminRole->syncPermissions($permissions);

            // Assign the super-admin role to the user
            $user->assignRole($superAdminRole);
        }
    }
}
