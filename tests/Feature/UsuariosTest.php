<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;


class UsuariosTest extends TestCase
{
     //refrescamos base de datos y logiamos
     use RefreshDatabase;

     protected $user;
 
     protected function setUp(): void
     {
         parent::setUp();
 
         $this->user = User::factory()->create();
 
         $this->actingAs($this->user);
 
         //migramos y sembramos
         $this->artisan('migrate:refresh');
         $this->artisan('db:seed');
     }

    public function test_formulario_cambiar_clave()
    {
        $response = $this->get('/contrasenia');

        $response->assertStatus(200);
        $response->assertViewIs('User.clave');
    }

    public function test_actualizar_clave()
    {
        $user = \App\Models\User::factory()->create();
        $oldPassword = 'password';//la contraseña por defecto
        $newPassword = 'clave_nueva';

        $this->actingAs($user);

        $response = $this->post('/contrasenia', [
            'viejapassword' => $oldPassword,
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ]);

        $response->assertRedirect('/');
        $this->assertTrue(Hash::check($newPassword, $user->fresh()->password));
    }

    public function test_listado_usuarios_sin_roles()
    {
        $response = $this->get('/listado');

        $response->assertStatus(200);
        $response->assertViewHas('usuarios');
        $usuarios = $response->original->getData()['usuarios'];
        $this->assertGreaterThan(0, count($usuarios));
    }

    public function test_actualizar_clave_con_clave_incorrecta()
    {
        $user = \App\Models\User::factory()->create();
        $oldPassword = 'password';//la contraseña por defecto
        $newPassword = 'clave_nueva';

        $this->actingAs($user);

        $response = $this->post('/contrasenia', [
            'viejapassword' => 'clave_incorrecta',
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ]);

        $response->assertRedirect('/contrasenia');
        $this->assertFalse(Hash::check($newPassword, $user->fresh()->password));
        $response->assertSessionHasErrors();
    }

    public function test_registrar_usuario_con_informacion_invalida()
    {
        $response = $this->post('/registrar', [
            'name' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertSessionHasErrors();
    }



    

    public function test_user_probar_rol_admin()
    {
        $user = \App\Models\User::factory()->create();
        $role = Role::create(['name' => 'admin']);
        $user->assignRole($role);

        $this->actingAs($user);

        $response = $this->get('/listado');

        $response->assertStatus(200);
        $response->assertViewHas('usuarios');
        $usuarios = $response->original->getData()['usuarios'];
        $this->assertCount(1, $usuarios);
    }

    //usuario existente
    public function test_registrar_usuario_existente()
    {
        $response = $this->post('/registrar', [
            'username' => 'admin13790tds',
            'name' => 'Administrador',
            'correo' => 'cosme@gmail.com',
            'nacimiento' => '19990909',
            'identidad' => '0000000000000',
            'telefono' => '00000000',
            'password' => bcrypt('cosme13790'),
        ]);

        $response->assertStatus(302); // Asegúrate de que la petición fue redirigida
        $response->assertSessionHasErrors(); // Asegúrate de que hay errores en la sesión (porque el usuario ya existe)
    }

    //usuario nuevo
    public function test_registrar_usuario_nuevo()
    {
        $userData = [
            'username' => 'nuevoUsuario',
            'name' => 'Nuevo Usuario',
            'correo' => 'nuevoUsuario@gmail.com',
            'nacimiento' => '19990909',
            'identidad' => '1234567890123',
            'telefono' => '12345678',
            'password' => bcrypt('nuevoUsuario123'),
        ];

        $response = $this->post('/registrar', $userData);

        $response->assertStatus(302); // Asegúrate de que la petición fue redirigida
        $response->assertSessionHasNoErrors(); // Asegúrate de que no hay errores en la sesión

        $this->assertDatabaseHas('users', [
            'username' => $userData['username'],
            'correo' => $userData['correo'],
        ]);
    }

    public function test_actualizar_usuario()
    {
        $user = \App\Models\User::factory()->create();
        $userData = [
            'username' => 'nuevoUsuario',
            'name' => 'Nuevo Usuario',
            'correo' => 'nuevouser@gmail.com',
            'nacimiento' => '19990909',
            'identidad' => '1234567890123',
            'telefono' => '12345678',
            'password' => bcrypt('nuevoUsuario123'),
        ];

        $this->actingAs($user);

        // Incluir el ID del usuario en la ruta
        $response = $this->put('/usuario/' . $user->id . '/editar', $userData);

        $response->assertStatus(302); // Asegúrate de que la petición fue redirigida
    }

    public function test_registrar_usuario_con_correo_existente()
    {
        $existingUser = \App\Models\User::factory()->create(['correo' => 'existente@gmail.com']);

        $userData = [
            'username' => 'nuevoUsuario',
            'name' => 'Nuevo Usuario',
            'correo' => 'existente@gmail.com',
            'nacimiento' => '19990909',
            'identidad' => '1234567890123',
            'telefono' => '12345678',
            'password' => bcrypt('nuevoUsuario123'),
        ];

        $response = $this->post('/registrar', $userData);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('correo');
    }

    public function test_actualizar_usuario_con_correo_existente()
    {
        $existingUser = \App\Models\User::factory()->create(['correo' => 'existente@gmail.com']);
        $userToUpdate = \App\Models\User::factory()->create();

        $this->actingAs($userToUpdate);

        $userData = [
            'username' => 'nuevoUsuario',
            'name' => 'Nuevo Usuario',
            'correo' => 'existente@gmail.com',
            'nacimiento' => '19990909',
            'identidad' => '1234567890123',
            'telefono' => '12345678',
            'password' => bcrypt('nuevoUsuario123'),
        ];

        $response = $this->put('/usuario/' . $userToUpdate->id . '/editar', $userData);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('correo');
    }

    public function test_registrar_usuario_con_username_existente()
    {
        $existingUser = \App\Models\User::factory()->create(['username' => 'existente']);

        $userData = [
            'username' => 'existente',
            'name' => 'Nuevo Usuario',
            'correo' => 'nuevoUsuario@gmail.com',
            'nacimiento' => '19990909',
            'identidad' => '1234567890123',
            'telefono' => '12345678',
            'password' => bcrypt('nuevoUsuario123'),
        ];

        $response = $this->post('/registrar', $userData);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('username');
    }



    public function test_actualizar_perfil_usuario()
    {
        $user = \App\Models\User::factory()->create();
        $userData = [
            'name' => 'Nombre Actualizado',
            'correo' => 'correoactualizado@gmail.com',
        ];

        $this->actingAs($user);

        $response = $this->put('/usuario/' . $user->id . '/editar', $userData);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $userData['name'],
            'correo' => $userData['correo'],
        ]);
    }

    public function test_eliminar_cuenta_usuario()
    {
        $user = \App\Models\User::factory()->create();

        $this->actingAs($user);

        $response = $this->delete('/usuario/' . $user->id . '/eliminar');

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();

        $response->assertDeleted($user);
    }
}
