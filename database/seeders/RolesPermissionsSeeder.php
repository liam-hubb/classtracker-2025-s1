<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionsSeeder extends Seeder
{
    private $permissions = [
        'system-configuration',
        'manage-roles',
        'manage-domains',
        'user-management',
        'backup-management',
        'import-export',
        'class-session-management',
        'approve-changes',
        'view-all-class-sessions',
        'view-own-class-sessions',
        'edit-own-profile',
        'request-changes',
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
                'class-session-management',
                'approve-changes',
                'view-all-class-sessions',
                'view-own-class-sessions',
                'edit-own-profile',
                'request-changes',
            ],
            'Staff' => [
                'class-session-management',
                'approve-changes',
                'view-own-class-sessions',
                'edit-own-profile',
                'request-changes',
            ],
            'Student' => [
                'edit-own-profile',
                'request-changes',
            ],
        ];

        foreach ($rolesWithPermissions as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($permissions);
        }
    }
}
