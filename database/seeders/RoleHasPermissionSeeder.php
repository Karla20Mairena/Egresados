<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleHasPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        //$ordinario_permissions = Permission::whereBetween('id', [1, 4]);
        $administrador_permissions = Permission::all();

            // admin
            Role::findOrFail(1)->permissions()->sync($administrador_permissions->pluck('id'));
            //ordinario
            //Role::findOrFail(2)->permissions()->sync($ordinario_permissions->pluck('id'));
    }
}

