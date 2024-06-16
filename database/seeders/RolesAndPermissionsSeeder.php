<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;
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
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Roles
        $roles = [
            'admin' => 'Admin',
            'collection_agent' => 'Collection Agent',
            'operator' => 'Operator'
        ];

        foreach ($roles as $role => $description) {
            Role::create([
                'name' => $role,
                'description' => $description,
            ]);
        }

        /* Create Permissions */
        $permissions = [
            'users' => [
                'view_users' => 'View Users',
                'add_users' => 'Add Users',
                'edit_users' => 'Edit Users',
                'delete_users' => 'Delete Users',
            ],
            'customers' => [
                'view_customers' => 'View Customers',
                'add_customers' => 'Add Customers',
                'edit_customers' => 'Edit Customers',
                'delete_customers' => 'Delete Customers',
            ],
            'loans' => [
                'view_loans' => 'View Loans',
                'add_loans' => 'Add Loans',
                'edit_loans' => 'Edit Loans',
                'delete_loans' => 'Delete Loans',
            ]
        ];

        foreach($permissions as $module => $permission) {
            foreach($permission as $name => $description) {
                Permission::create([
                    'name' => $name,
                    'guard_name' => "web",
                    'description' => $description,
                    'module' => $module,
                ]);
            }
        }

        // Assign Permissions to Roles
        $rolePermissions = [
            'admin' => Permission::all(),
            'operator' => [
                'view_customers',
                'add_customers',
                'edit_customers',
                'view_loans',
                'add_loans',
                'edit_loans'
            ],
            'collection_agent' => [
                'view_customers',
                'view_loans'
            ]
        ];

        // Assign permissions to roles
        foreach ($rolePermissions as $role => $permissionList) {
            $roleInstance = Role::where('name', $role)->first();
            if ($role === 'admin') {
                $roleInstance->syncPermissions($permissionList);
            } else {
                $permissions = Permission::whereIn('name', $permissionList)->get();
                $roleInstance->syncPermissions($permissions);
            }
        }
    }
}
