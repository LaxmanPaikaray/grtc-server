<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Helpers\RolePermissions;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // super-admin has all permissions. This is going to be handled separately. 
        // This role will not be provided any permissions indivudually.
        Role::create(['name' => RolePermissions::ROLE_SUPER_ADMIN]);

        $admin = Role::create(['name' => RolePermissions::ROLE_ADMIN]);
        $basic = Role::create(['name' => RolePermissions::ROLE_BASIC]);
        Role::create(['name' => RolePermissions::ROLE_STUDENT]);
        Role::create(['name' => RolePermissions::ROLE_PARENT]);
        Role::create(['name' => RolePermissions::ROLE_TEACHER]);
        Role::create(['name' => RolePermissions::ROLE_SALES]);
        Role::create(['name' => RolePermissions::ROLE_SUPPORT]);
        Role::create(['name' => RolePermissions::ROLE_PROSPECT]);

        $listLocation = Permission::create(['name' => RolePermissions::PERM_LIST_LOCATIONS]);
        $addLocation = Permission::create(['name' => RolePermissions::PERM_ADD_UPDATE_LOCATIONS]);
        $deleteLocation = Permission::create(['name' => RolePermissions::PERM_DELETE_LOCATIONS]);

        $listSchool = Permission::create(['name' => RolePermissions::PERM_LIST_SCHOOLS]);
        $addSchool = Permission::create(['name' => RolePermissions::PERM_ADD_UPDATE_SCHOOLS]);
        $deleteSchool = Permission::create(['name' => RolePermissions::PERM_DELETE_SCHOOLS]);

        $admin->givePermissionTo([
            $listLocation,
            $addLocation,
            $deleteLocation,
            $listSchool,
            $addSchool,
            $deleteSchool,
        ]);

        $basic->givePermissionTo([
            $listLocation,
            $listSchool,
        ]);
    }
}
