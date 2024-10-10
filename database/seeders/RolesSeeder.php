<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // إنشاء الأذونات
        $permissions = [
            'create tasks',
            'edit tasks',
            'delete tasks',
            'view all tasks',
            'manage users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // إنشاء الأدوار وتعيين الأذونات
        $rolesPermissions = [
            'admin' => [
                'create tasks',
                'edit tasks',
                'delete tasks',
                'view all tasks',
                'manage users',
            ],
            'editor' => [
                'edit tasks',
                'view all tasks',
            ],
            'user' => [
                'create tasks',
                'edit tasks',
                'delete tasks',
            ],
        ];

        foreach ($rolesPermissions as $role => $permissions) {
            $roleInstance = Role::firstOrCreate(['name' => $role]);
            $roleInstance->syncPermissions($permissions);
        }
    


    }}  