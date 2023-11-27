<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolesYPermisosTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_asignar_y_revocar_roles_y_permisos_usuario()
    {
        $user = \App\Models\User::factory()->create();
        $role = Role::create(['name' => 'admin']);

        $this->actingAs($user);

        // Asignar rol
        $response = $this->post('/usuario/' . $user->id . '/asignarrol', ['role' => $role->id]);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();

        $this->assertTrue($user->fresh()->hasRole('admin'));

        // Revocar rol
        $response = $this->post('/usuario/' . $user->id . '/revocarrol', ['role' => $role->id]);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();

        $this->assertFalse($user->fresh()->hasRole('admin'));
    }

    public function test_asignar_y_revocar_permisos_usuario()
    {
        $user = \App\Models\User::factory()->create();
        $permission = Permission::create(['name' => 'create_usuario']);

        $this->actingAs($user);

        // Asignar permiso
        $response = $this->post('/usuario/' . $user->id . '/asignarpermiso', ['permission' => $permission->id]);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();

        $this->assertTrue($user->fresh()->hasPermissionTo('create_usuario'));

        // Revocar permiso
        $response = $this->post('/usuario/' . $user->id . '/revocarpermiso', ['permission' => $permission->id]);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();

        $this->assertFalse($user->fresh()->hasPermissionTo('create_usuario'));
    }

    public function test_usuario_puede_crear_usuario_si_tiene_permiso()
    {
        $user = \App\Models\User::factory()->create();
        $permission = Permission::create(['name' => 'create_usuario']);

        $user->givePermissionTo($permission);

        $this->actingAs($user);

        $newUserData = [
            'username' => 'nuevoUsuario',
            'name' => 'Nuevo Usuario',
            'correo' => 'nuevoUsuario@gmail.com',
            'nacimiento' => '19990909',
            'identidad' => '1234567890123',
            'telefono' => '12345678',
            'password' => bcrypt('nuevoUsuario123'),
        ];

        $response = $this->post('/usuario/crear', $newUserData);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('users', [
            'username' => $newUserData['username'],
            'name' => $newUserData['name'],
            'correo' => $newUserData['correo'],
        ]);
    }

    public function test_usuario_no_puede_crear_usuario_si_no_tiene_permiso()
    {
        $user = \App\Models\User::factory()->create();

        $this->actingAs($user);

        $newUserData = [
            'username' => 'nuevoUsuario',
            'name' => 'Nuevo Usuario',
            'correo' => 'nuevoUsuario@gmail.com',
            'nacimiento' => '19990909',
            'identidad' => '1234567890123',
            'telefono' => '12345678',
            'password' => bcrypt('nuevoUsuario123'),
        ];

        $response = $this->post('/usuario/crear', $newUserData);

        $response->assertStatus(403);
    }

    public function test_usuario_puede_editar_usuario_si_tiene_permiso()
    {
        $user = \App\Models\User::factory()->create();
        $permission = Permission::create(['name' => 'edit_usuario']);

        $user->givePermissionTo($permission);

        $this->actingAs($user);

        $otherUser = \App\Models\User::factory()->create();
        $updatedUserData = [
            'username' => 'usuarioEditado',
            'name' => 'Usuario Editado',
            'correo' => 'usuarioEditado@gmail.com',
        ];

        $response = $this->put('/usuario/' . $otherUser->id . '/editar', $updatedUserData);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('users', [
            'id' => $otherUser->id,
            'username' => $updatedUserData['username'],
            'name' => $updatedUserData['name'],
            'correo' => $updatedUserData['correo'],
        ]);
    }

    public function test_usuario_no_puede_editar_usuario_si_no_tiene_permiso()
    {
        $user = \App\Models\User::factory()->create();

        $this->actingAs($user);

        $otherUser = \App\Models\User::factory()->create();
        $updatedUserData = [
            'username' => 'usuarioEditado',
            'name' => 'Usuario Editado',
            'correo' => 'usuarioEditado@gmail.com',
        ];

        $response = $this->put('/usuario/' . $otherUser->id . '/editar', $updatedUserData);

        $response->assertStatus(403);
    }

    public function test_usuario_puede_eliminar_usuario_si_tiene_permiso()
    {
        $user = \App\Models\User::factory()->create();
        $permission = Permission::create(['name' => 'delete_usuario']);

        $user->givePermissionTo($permission);

        $this->actingAs($user);

        $otherUser = \App\Models\User::factory()->create();

        $response = $this->delete('/usuario/' . $otherUser->id . '/eliminar');

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();

        $response->assertDeleted($otherUser);
    }

    public function test_usuario_no_puede_eliminar_usuario_si_no_tiene_permiso()
    {
        $user = \App\Models\User::factory()->create();

        $this->actingAs($user);

        $otherUser = \App\Models\User::factory()->create();

        $response = $this->delete('/usuario/' . $otherUser->id . '/eliminar');

        $response->assertStatus(403);
    }

    public function test_acceso_a_pagina_protegida_sin_permiso()
    {
        $user = \App\Models\User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/egresado');

        $response->assertStatus(403); // Código de estado HTTP para "Prohibido"
    }

    public function test_acceso_a_pagina_protegida_con_permiso()
    {
        $user = \App\Models\User::factory()->create();
        $permission = Permission::create(['name' => 'index_usuario']);

        $user->givePermissionTo($permission);

        $this->actingAs($user);

        $response = $this->get('/egresado');

        $response->assertStatus(200);
    }

    public function test_asignar_rol_o_permiso_ya_asignado_a_usuario()
    {
        $user = \App\Models\User::factory()->create();
        $role = Role::findByName('admin'); // Usar el rol 'admin' de tus seeders
        $permission = Permission::findByName('create_usuario'); // Usar el permiso 'create_usuario' de tus seeders

        $user->assignRole($role);
        $user->givePermissionTo($permission);

        $this->actingAs($user);

        // Intentar asignar el mismo rol nuevamente
        $response = $this->post('/registrar', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => $role->id
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(); // Debería haber errores en la sesión si el rol ya ha sido asignado

        // Intentar asignar el mismo permiso nuevamente
        $response = $this->post('/registrar', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
            'permission' => $permission->id
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(); // Debería haber errores en la sesión si el permiso ya ha sido asignado
    }
}
