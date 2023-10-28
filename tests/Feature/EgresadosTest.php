<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Egresado;
use App\Models\Genero;
use App\Models\Carrera;


class EgresadosTest extends TestCase
{
    
    public function testIndexEgresado()
    {
        $response = $this->get('/egresado/index');
        $response->assertStatus(200);
    }

    public function testCrearEgresado()
    {
        $response = $this->get('/egresado/create');
        $response->assertStatus(200);
    }

    public function testGuardarEgresado()
    {
        $genero = Genero::all();
        $carrera = Carrera::all();

        $data = [
            'identidad' => '0703200108528',
            'nombre' => 'Juan Carlos',
            'fecha' => '2001-05-06',
            'gene_id' => $genero->id,
            'carre_id' => $carrera->id,
            'egreso' => 2022,
        ];

        $response = $this->post('/egresado', $data);
        $response->assertStatus(302);
        $this->assertDatabaseHas('egresados', ['nombre' => 'Juan Carlos']);
    }

    public function testEditarEgresado()
    {
        $egresado = Egresado::find($egresado->id);
        $response = $this->get("/egresado/{$egresado->id}/edit");
        $response->assertStatus(200);
        $response->assertSee($egresado->nombre);
    }

    public function testActualizarEgresado()
    {
        $egresado = Egresado::factory()->create();
        $genero = Genero::factory()->create();
        $carrera = Carrera::factory()->create();

        $data = [
            'nombre' => 'Nombre Actualizado',
            'gene_id' => $genero->id,
            'carre_id' => $carrera->id,
        ];

        $response = $this->put("/egresado/{$egresado->id}", $data);
        $response->assertStatus(302); 
        $this->assertDatabaseHas('egresados', ['nombre' => 'Nombre Actualizado']);
    }

    public function testEliminarEgresado()
    {
        $egresado = Egresado::factory()->create();
        $response = $this->delete("/egresado/{$egresado->id}");
        $response->assertStatus(302); 
        $this->assertDatabaseMissing('egresados', ['id' => $egresado->id]);
    }
}