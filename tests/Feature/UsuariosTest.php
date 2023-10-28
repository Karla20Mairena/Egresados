<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsuariosTest extends TestCase
{
    public function test_formulario_cambiar_clave()
    {
        $response = $this->get('/formularioclave');

        $response->assertStatus(200);
        $response->assertViewIs('User.clave');
    }

    public function test_actualizar_clave()
    {
        $user = \App\Models\User::factory()->create();
        $oldPassword = 'clave_antigua';
        $newPassword = 'clave_nueva';

        $this->actingAs($user);

        $response = $this->post('/guardarclave', [
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
        $this->assertCount(0, $usuarios);
    }

    public function test_actualizar_clave_con_clave_incorrecta()
    {
        $user = \App\Models\User::factory()->create();
        $oldPassword = 'clave_antigua';
        $newPassword = 'clave_nueva';

        $this->actingAs($user);

        $response = $this->post('/guardarclave', [
            'viejapassword' => 'clave_incorrecta',
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ]);

        $response->assertRedirect('/formularioclave');
        $this->assertFalse(Hash::check($newPassword, $user->fresh()->password));
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
}