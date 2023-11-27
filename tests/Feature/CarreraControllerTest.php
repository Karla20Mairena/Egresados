<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Carrera;
use Illuminate\Support\Facades\DB;

class CarreraControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_CarreraRequerida()
    {
        $response = $this->post('/carreras', [
            'carrera' => '',
        ]);

        $response->assertSessionHasErrors('carrera');
    }


    public function test_CarreraMaxCaracteresLimites()
    {
        $response = $this->post('/carreras', [
            'carrera' => str_repeat('a', 99), // Supera el límite de caracteres
        ]);

        $response->assertSessionHasErrors('carrera');
    }

    public function test_CarreraMinCaracteresLimites()
    {
        $response = $this->post('/carreras', [
            'carrera' => str_repeat('a', 3),
        ]);

        $response->assertSessionHasErrors('carrera');
    }

    public function test_carrera_con_espacios()
    {
        $response = $this->post('/carreras', [
            'carrera' => '     ',
        ]);
        $response->assertSessionHasErrors('carrera');
    }

    public function test_limite_caracteres_carrera()
    {
        $response = $this->post('/carreras', [
            'carrera' => str_repeat('a', 256),
        ]);
        $response->assertSessionHasErrors('carrera');
    }

    public function test_carrera_con_caracteres_especiales()
    {
        $response = $this->post('/carreras', [
            'carrera' => '!@#$%^&*()',
        ]);
        $response->assertSessionHasErrors('carrera');
    }

    public function test_carrera_con_numeros()
    {
        $response = $this->post('/carreras', [
            'carrera' => '1234567890',
        ]);
        $response->assertSessionHasErrors('carrera');
    }

    public function test_carrera_con_caracteres_especiales_y_numeros()
    {
        $response = $this->post('/carreras', [
            'carrera' => '!@#$%^&*()1234567890',
        ]);
        $response->assertSessionHasErrors('carrera');
    }

    public function test_guardar_carrera()
    {
        DB::beginTransaction();
        $response = $this->post('/carreras', [
            'carrera' => 'Ingeniería en Sistemas Computacionales',
        ]);

        $response->assertRedirect('/carreras');
        DB::rollback();
    }

    public function test_editar_carrera()
    {
        DB::beginTransaction();
        $carrera = Carrera::factory()->create();
        $response = $this->put('/carreras/' . $carrera->id, [
            'carrera' => 'Ingeniería en Sistemas Computacionales',
        ]);

        $response->assertRedirect('/carreras');
        DB::rollback();
    }

    public function test_eliminar_carrera()
    {
        DB::beginTransaction();
        $carrera = Carrera::factory()->create();
        $response = $this->delete('/carreras/' . $carrera->id);

        $response->assertRedirect('/carreras');
        DB::rollback();
    }

    public function test_carrera_repetida()
    {
        DB::beginTransaction();
        $carrera = Carrera::factory()->create();
        $response = $this->post('/carreras', [
            'carrera' => $carrera->carrera,
        ]);

        $response->assertSessionHasErrors('carrera');
        DB::rollback();
    }

    public function test_carrera_repetida_en_edicion()
    {
        DB::beginTransaction();
        $carrera = Carrera::factory()->create();
        $carrera2 = Carrera::factory()->create();
        $response = $this->put('/carreras/' . $carrera->id, [
            'carrera' => $carrera2->carrera,
        ]);

        $response->assertSessionHasErrors('carrera');
        DB::rollback();
    }

    public function test_visualizar_carrera()
    {
        DB::beginTransaction();
        $carrera = Carrera::factory()->create();
        $response = $this->get('/carreras/' . $carrera->id);

        $response->assertStatus(200);
        DB::rollback();
    }

    public function test_visualizar_carrera_inexistente()
    {
        DB::beginTransaction();
        $response = $this->get('/carreras/9999');

        $response->assertStatus(404);
        DB::rollback();
    }

    public function test_editar_carrera_inexistente()
    {
        DB::beginTransaction();
        $response = $this->put('/carreras/9999', [
            'carrera' => 'Ingeniería en Sistemas Computacionales',
        ]);

        $response->assertStatus(404);
        DB::rollback();
    }

    public function test_carrera_null()
    {
        DB::beginTransaction();
        $response = $this->post('/carreras', [
            'carrera' => null,
        ]);

        $response->assertSessionHasErrors('carrera');
        DB::rollback();
    }
}
