<?php

namespace Tests\Feature;

use App\Models\Egresado;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EliminarEgresado extends TestCase
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
   

    public function test_borrarEgresado()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        // Creamos un egresado utilizando el factory.
        $egresado = Egresado::factory()->create();

        // Llamamos a la función destroy.
        $response = $this->delete(route('egresado.destroy', $egresado->id));

        // Aseguramos que el usuario es redirigido al índice de egresados.
        $response->assertRedirect(route('egresado.index'));

        // Aseguramos que el mensaje de confirmación es mostrado.
        $response->assertSessionHas('mensaje', 'Egresado fue borrado completamente');
    }

    public function test_borrarEgresadoSiNoExiste()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        // Usamos un ID  que no debería existir.
        $invalidId = 9999;

        // Llamamos a la función destroy.
        $response = $this->delete(route('egresado.destroy', $invalidId));

        // Esperamos una respuesta de error (por ejemplo, 404 Not Found).
        $response->assertStatus(404);
    }


}