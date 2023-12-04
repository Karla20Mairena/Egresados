<?php

namespace Tests\Feature;

use App\Models\Egresado;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EgresadoDestroyTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_autenticado_puede_eliminar_egresado()
    {
        $user = User::factory()->create();
        $egresado = Egresado::factory()->create();

        $response = $this->actingAs($user)->delete(route('egresado.destroy', $egresado));

        $response->assertRedirect('/egresado');
        $this->assertDatabaseMissing('egresados', ['id' => $egresado->id]);
    }

    public function test_usuario_no_autenticado_no_puede_eliminar_egresado()
    {
        $egresado = Egresado::factory()->create();

        $response = $this->delete(route('egresado.destroy', $egresado));

        $response->assertRedirect('login');
        $this->assertDatabaseHas('egresados', ['id' => $egresado->id]);
    }

    public function test_redirecciona_correctamente_despues_de_eliminar_egresado()
    {
        $user = User::factory()->create();
        $egresado = Egresado::factory()->create();

        $response = $this->actingAs($user)->delete(route('egresado.destroy', $egresado));

        $response->assertRedirect('/egresado');
    }

    public function test_muestra_mensaje_correcto_despues_de_eliminar_egresado()
    {
        $user = User::factory()->create();
        $egresado = Egresado::factory()->create();

        $response = $this->actingAs($user)->delete(route('egresado.destroy', $egresado));

        $response->assertSessionHas('mensaje', 'Egresado fue borrado completamente');
    }

    public function test_usuario_autenticado_no_puede_eliminar_egresado_inexistente()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->delete(route('egresado.destroy', 9999));

        $response->assertStatus(404);
    }

    public function test_usuario_autenticado_no_puede_eliminar_egresado_que_no_le_pertenece()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $egresado = Egresado::factory()->create(['user_id' => $user1->id]);

        $response = $this->actingAs($user2)->delete(route('egresado.destroy', $egresado->id));

        $response->assertStatus(403);
        $this->assertDatabaseHas('egresados', ['id' => $egresado->id]);
    }
}
