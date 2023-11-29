<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class ProfileTest extends TestCase
{

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Buscar el usuario en la base de datos por correo electrónico
        $this->user = User::where('correo', 'cosme@gmail.com')
        ->orWhere('correo', 'cosme2@gmail.com')
        ->first();

        // Si no puedes encontrar el usuario, podrías querer lanzar un error para que sepas que algo está mal
        if (!$this->user) {
            $this->fail('Usuario no encontrado');
        }

        // Actuar como el usuario encontrado
        $this->actingAs($this->user);
    }

    //Esta es una prueba que verifica si la página que contiene el formulario de editar perfil está disponible y devuelve un 
    //código de estado HTTP 200.
    public function testEditFormIsAvailable()
    {
        $response = $this->get('/usuario/editar');
        $response->assertStatus(200);
    }

    public function testActualizarPerfil()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::beginTransaction();
        $user = User::factory()->create();
        $data = ['name' => 'Nombre Actualizado'];

        $response = $this->put("/usuario/{$user->id}", $data);
        DB::rollBack();
        $response->assertStatus(302); 
    }

    public function testNombreUsuarioNull()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $user =User::factory()->create();
        $data =User::factory()->make(['name' => null])->toArray();

        $response = $this->put("/usuario/{$user->id}", $data);

        $response->assertSessionHasErrors('name');
    }

    public function testNombreUsuarioExtenso()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $user = User::factory()->create();
        $data = User::factory()->make(['name' => 'Nolvia Gisella Rodriguez Lazo de Sorto Flores Gonzalez Hernandez',])->toArray();

        $response = $this->put("/usuario/{$user->id}", $data);

        $response->assertSessionHasErrors('name');
    }

    public function testNombreUsuarioCorto()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $user = User::factory()->create();
        $data = User::factory()->make(['name' => 'N',])->toArray();

        $response = $this->put("/usuario/{$user->id}", $data);

        $response->assertSessionHasErrors('name');
    }

    public function testNombreUsuarioNumerico()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $user = User::factory()->create();
        $data = User::factory()->make(['name' => '12345689',])->toArray();

        $response = $this->put("/usuario/{$user->id}", $data);

        $response->assertSessionHasErrors('name');
    }


    public function testUsernameNull()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $user =User::factory()->create();
        $data =User::factory()->make(['username' => null])->toArray();

        $response = $this->put("/usuario/{$user->id}", $data);

        $response->assertSessionHasErrors('username');
    }

    public function testUsernameExtenso()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $user = User::factory()->create();
        $data = User::factory()->make(['username' => 'Nolvia Gisella Rodriguez Lazo de Sorto Flores Gonzalez Hernandez',])->toArray();

        $response = $this->put("/usuario/{$user->id}", $data);

        $response->assertSessionHasErrors('username');
    }

    public function testUsernameCorto()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $user = User::factory()->create();
        $data = User::factory()->make(['username' => 'N',])->toArray();

        $response = $this->put("/usuario/{$user->id}", $data);

        $response->assertSessionHasErrors('username');
    }

    public function testUsernameNumerico()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $user = User::factory()->create();
        $data = User::factory()->make(['username' => '123456795',])->toArray();

        $response = $this->put("/usuario/{$user->id}", $data);

        $response->assertSessionHasErrors('username');
    }

    public function testNacimientoUsuarioNull()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $user =User::factory()->create();
        $data =User::factory()->make(['nacimiento' => null])->toArray();

        $response = $this->put("/usuario/{$user->id}", $data);

        $response->assertSessionHasErrors('nacimiento');
    }

    public function testCorreoUsuarioNull()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $user =User::factory()->create();
        $data =User::factory()->make(['correo' => null])->toArray();

        $response = $this->put("/usuario/{$user->id}", $data);

        $response->assertSessionHasErrors('correo');
    }

    public function testIdentidadUsuarioNull()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $user =User::factory()->create();
        $data =User::factory()->make(['identidad' => null])->toArray();

        $response = $this->put("/usuario/{$user->id}", $data);

        $response->assertSessionHasErrors('identidad');
    }

    public function testTelefonoUsuarioNull()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $user =User::factory()->create();
        $data =User::factory()->make(['telefono' => null])->toArray();

        $response = $this->put("/usuario/{$user->id}", $data);

        $response->assertSessionHasErrors('telefono');
    }

    public function testChangePassword()
    {
        $user = User::find(1);
        
        // Simula una solicitud para cambiar la contraseña
        $response = $this->put('/profile/password', [
            'password' => 'nuevacontraseña',
            'password_confirmation' => 'nuevacontraseña',
        ]);

        // Verifica que la respuesta sea exitosa
        $response->assertStatus(302);

        // Verifica que la contraseña se haya actualizado en la base de datos
        $this->assertCredentials([
            'correo' => $user->correo,
            'password' => 'nuevacontraseña',
        ]);
    }
}

