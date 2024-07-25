<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $editorRole = Role::create(['name' => 'Editor']);
        $managerRole = Role::create(['name' => 'Manager']);

         // Create permissions for CRUD operations on departments
         $viewDepartments = Permission::create(['name' => 'View Departments']);
         $addDepartments = Permission::create(['name' => 'Add Departments']);
         $editDepartments = Permission::create(['name' => 'Edit Departments']);
         $deleteDepartments = Permission::create(['name' => 'Delete Departments']);
 
         // Create permission to view the dashboard
         $viewDashboard = Permission::create(['name' => 'View Dashboard']);
         $editorRole->givePermissionTo([
            $viewDepartments,
            $addDepartments,
            $editDepartments,
            $deleteDepartments,
            $viewDashboard
        ]);

        $managerRole->givePermissionTo([
            $viewDepartments,
            $viewDashboard
        ]);
    }
}
