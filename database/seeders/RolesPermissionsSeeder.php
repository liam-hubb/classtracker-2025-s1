<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionsSeeder extends Seeder
{
    private $permissions = [
        // System permissions
        'system-configuration',
        'manage-roles',
        'manage-domains',
        'user-management',
        'backup-management',
        'import-export',

        // Class and lesson management
        'class-lesson-management',
        'approve-changes',
        'view-all-class-lessons',
        'view-own-class-lessons',

        // User profile permissions
        'edit-own-profile',
        'request-changes',

        // Unit permissions
        'view-units',
        'create-units',
        'edit-units',
        'delete-units',

        // Course permissions
        'view-courses',
        'create-courses',
        'edit-courses',
        'delete-courses',

        // Package permissions
        'view-packages',
        'create-packages',
        'edit-packages',
        'delete-packages',

        // Cluster permissions
        'view-clusters',
        'create-clusters',
        'edit-clusters',
        'delete-clusters',

        // Lesson permissions
        'view-lessons',
        'create-lessons',
        'edit-lessons',
        'delete-lessons',

        // User management permissions
        'view-users',
        'create-users',
        'edit-users',
        'delete-users',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->permissions as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }

        $rolesWithPermissions = [
            'Super Admin' => $this->permissions,
            'Admin' => [
                'manage-domains',
                'user-management',
                'backup-management',
                'import-export',
                'class-lesson-management',
                'approve-changes',
                'view-all-class-lessons',
                'view-own-class-lessons',
                'edit-own-profile',
                'request-changes',
                'view-units', 'create-units', 'edit-units', 'delete-units',
                'view-courses', 'create-courses', 'edit-courses', 'delete-courses',
                'view-packages', 'create-packages', 'edit-packages', 'delete-packages',
                'view-clusters', 'create-clusters', 'edit-clusters', 'delete-clusters',
                'view-lessons', 'create-lessons', 'edit-lessons', 'delete-lessons',
                'view-users', 'create-users', 'edit-users', 'delete-users',
            ],

            'Staff' => [
                'class-lesson-management',
                'approve-changes',
                'view-own-class-lessons',
                'edit-own-profile',
                'request-changes',
                'view-units',
                'view-courses',
                'view-packages',
                'view-clusters',
                'view-lessons', 'create-lessons', 'edit-lessons',
            ],

            'Student' => [
                'edit-own-profile',
                'request-changes',
                'view-lessons',
            ],
        ];

        foreach ($rolesWithPermissions as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($permissions);
        }
    }
}
