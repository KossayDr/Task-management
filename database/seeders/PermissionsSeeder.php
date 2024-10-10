<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    // this is orginal
    public function run()
    {
        $arrayOfPermissionsName = [
            'add user',
            'edit user',
            'delete user',
            'show user',
            
            'view tasks',
            'edit tasks',
            'delete tasks',
            
        ];

        $permissions = collect($arrayOfPermissionsName)->map(function ($permission){
            return ['name' => $permission, 'guard_name'=> 'web'];
        });

        Permission::insert($permissions->toArray());

        $role = Role::create(['name' => 'admin'])->givePermissionTo($arrayOfPermissionsName);
       $role= Role::create(['name' => 'user', 'guard_name' => 'web']);

    }
}
