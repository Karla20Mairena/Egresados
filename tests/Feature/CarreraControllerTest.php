<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Carrera;

class CarreraControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_estadoDociento()
    {
        $response = $this->get('/carrearas');

        $response->assertStatus(200);
    }

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
            'carrera' => str_repeat('a', 101), // Supera el límite de caracteres
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
}