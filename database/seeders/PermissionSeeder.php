<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
           
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // spatie documentation
         app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        //Inicio Permissions de facultativo
        Permission::create([
            'titulo' => 'Crear Usuario',
            'name' => 'create_usuario',
        ]);
        Permission::create([
            'titulo' => 'Listado Usuario',
            'name' => 'index_usuario',
        ]);
       
        //activar y desactivar
        Permission::create([
            'titulo' => 'Desactivar y Activar Usuario',
            'name' => 'deactivar_activar_usuario',
        ]);

       
    }
}


