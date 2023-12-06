<?php

namespace Tests\Feature;

use App\Models\Egresado;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class EliminarEgresado extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

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