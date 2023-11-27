<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

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

        $response = $this->post(route('login',[
            'correo' => 'cosme@gmail.com',
            'password' => 'cosme13790'
        ]));

        $response->assertRedirect('/');
    }

    
    public function test_LoginSinDatos()
    {

        $response = $this->post(route('login',[
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

        $response = $this->post(route('login',[
            'correo' => '',
            'password' => '123456789'
        ]));

        $response->assertInvalid([
            'correo' => 'El campo correo es obligatorio.',
        ]);
    }

    public function test_LoginConPasswordVacio()
    {

        $response = $this->post(route('login',[
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

        $response = $this->post(route('login',[
            'correo' => 'correo@yahoo.com',
            'password' => 'cosme13790'
        ]));

        $response->assertInvalid([
            'correo' => 'Estas credenciales no coinciden con nuestros registros.'
        ]);
    }
}
