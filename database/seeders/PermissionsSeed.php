<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'View Clients',
            'Add Clients',
            'Edit Clients',
            'Delete Clients',

            'View Employees',
            'Add Employees',
            'Edit Employees',
            'Delete Employees',
            // Add other permissions as needed
            'View Invoices',
            'Add Invoices',
            'Edit Invoices',
            'Delete Invoices',
            'Show Invoices',

            'View Payments',
            'Add Payments',
            'Edit Payments',
            'Delete Payments',

            'View Categories',
            'Add Categories',
            'Edit Categories',
            'Delete Categories',

            'View Services',
            'Add Services',
            'Edit Services',
            'Delete Services',

            'View & Update Settings',
            'Roles & Permissions',
            'View Roles',
            'Add Roles',
            'Edit Roles',
            'Delete Roles',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
