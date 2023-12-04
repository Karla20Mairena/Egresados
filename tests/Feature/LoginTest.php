<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginTest extends TestCase
{
    public function test_AccederAOtraRutaSinLogin()
    {
        $response = $this->get(route('usuario.datos'));
        $response->assertRedirect(route('login'));
    }

    public function test_AccederALaRutaIncialSinLoguearse()
    {
        $response = $this->get('/');
        $response->assertRedirect(route('login'));
    }


    public function test_LoginConDatosCorrectos()
    {

        $response = $this->post(route('login', [
            'correo' => 'cosme@gmail.com',
            'password' => 'cosme13790'
        ]));

        $response->assertRedirect('/');
    }


    public function test_LoginSinDatos()
    {

        $response = $this->post(route('login', [
            'correo' => '',
            'password' => ''
        ]));

        $response->assertInvalid([
            'correo' => 'El campo correo es obligatorio.',
            'password' => 'El campo password es obligatorio.'
        ]);
    }

    public function test_LoginConCorreoVacio()
    {

        $response = $this->post(route('login', [
            'correo' => '',
            'password' => '123456789'
        ]));

        $response->assertInvalid([
            'correo' => 'El campo correo es obligatorio.',
        ]);
    }

    public function test_LoginConPasswordVacio()
    {

        $response = $this->post(route('login', [
            'correo' => 'cosme@gmail.com',
            'password' => ''
        ]));

        $response->assertInvalid([
            'password' => 'El campo password es obligatorio.'
        ]);
    }

    public function test_LoginConPasswordIncorrecta()
    {
        $response = $this->post(route('login', [
            'correo' => 'cosme@gmail.com',
            'password' => '123456789',
        ]));

        $response->assertInvalid([
            'correo' => 'Estas credenciales no coinciden con nuestros registros.'
        ]);
    }

    public function test_LoginConCorreoIncorrecto()
    {

        $response = $this->post(route('login', [
            'correo' => 'correo@yahoo.com',
            'password' => 'cosme13790'
        ]));

        $response->assertInvalid([
            'correo' => 'Estas credenciales no coinciden con nuestros registros.'
        ]);
    }

    public function test_usuario_puede_cerrar_sesion()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('logout'));

        $response->assertRedirect('/');
        $this->assertFalse(Auth::check());
    }

    public function test_usuario_no_puede_iniciar_sesion_con_contrasena_incorrecta()
    {
        $user = User::factory()->create();

        $response = $this->post(route('login'), [
            'correo' => $user->correo,
            'password' => 'contrasena_incorrecta'
        ]);

        $response->assertSessionHasErrors();
        $this->assertFalse(Auth::check());
    }

    public function test_usuario_no_puede_iniciar_sesion_con_correo_no_registrado()
    {
        $response = $this->post(route('login'), [
            'correo' => 'correo_no_registrado@gmail.com',
            'password' => 'contrasena'
        ]);

        $response->assertSessionHasErrors();
        $this->assertFalse(Auth::check());
    }

    public function test_usuario_no_puede_iniciar_sesion_si_cuenta_esta_desactivada()
    {
        $user = User::factory()->create(['estado' => 0]);

        $response = $this->post(route('login'), [
            'correo' => $user->correo,
            'password' => 'password'  // Asume que la contraseña es 'password'
        ]);

        $response->assertSessionHasErrors();
        $this->assertFalse(Auth::check());
    }

    public function test_usuario_puede_iniciar_sesion_si_cuenta_esta_activada()
    {
        $user = User::factory()->create(['estado' => 1]);

        $response = $this->post(route('login'), [
            'correo' => $user->correo,
            'password' => 'password'
        ]);

        $response->assertStatus(302);
        $this->assertTrue(Auth::check());
    }

    public function test_usuario_puede_restablecer_contrasena()
    {
        $user = User::factory()->create();

        $response = $this->post(route('password.email'), [
            'correo' => $user->correo,
        ]);

        $response->assertStatus(302);
    }

    public function test_usuario_no_puede_restablecer_contrasena_con_correo_no_registrado()
    {
        $response = $this->post(route('password.email'), [
            'correo' => 'correo_no_registrado@gmail.com',
        ]);

        $response->assertSessionHasErrors();
    }

    public function test_usuario_puede_cambiar_contrasena_despues_de_iniciar_sesion()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('password.update'), [
            'old_password' => 'password',  // Asume que la contraseña es 'password'
            'password' => 'new_password',
            'password_confirmation' => 'new_password',
        ]);

        $response->assertStatus(302);
        $this->assertTrue(Auth::check());
    }
}