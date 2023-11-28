<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Egresado;
use App\Models\Genero;
use App\Models\Carrera;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EgresadosTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->actingAs($this->user);

        //migramos y sembramos
        $this->artisan('migrate:refresh');
        $this->artisan('db:seed');
    }

    public function testGuardarEgresado()
    {
         //no puedes retornar a todos y luego utilizar ->id porque digamos hay 2 generos
        //y no sabria cual id tomaria de los 5 mejor devolver solo 1
        /*
        $genero = Genero::all();
        $carrera = Carrera::all();
        */
        $genero = Genero::inRandomOrder()->first();
        $carrera = Carrera::inRandomOrder()->first();

        $data = [
            'nombre' => 'Juan Carlos',
            'egreso' => '2021', //el atributo es egreso
            'fecha' => '2001-05-06', //el atributo es fecha
            'identidad' => '0703200108528',
            'expediente' => '203', //el atributo es expediente
            'gene_id' => $genero->id,
            'carre_id' => $carrera->id,
        ];

        $response = $this->post('/egresado', $data);
        $response->assertStatus(302);
        $this->assertDatabaseHas('egresados', ['nombre' => 'Juan Carlos']);
    }

    public function testEditarEgresado()
    {
        //creamos un egresado
        $egresado = Egresado::factory()->create();

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

            
            //le faltan los atributos restantes
            'egreso' => $egresado->año_egresado, //el atributo es egreso
            'fecha' => $egresado->fecha_nacimiento, //el atributo es fecha
            'identidad' => $egresado->identidad,
            'expediente' => $egresado->nro_expediente, //el atributo es expediente
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

    
    //Esta prueba verifica que el egresado o los egresados que no coinciden con la consulta no se muestran.
    public function testEgresado_NoMostrarDatosFiltrados()
    {
        $response = $this->get(route('egresado', ['q' => 'No Match']));
        $response->assertDontSeeText('Egresado Test');
    }


    //Esta prueba verifica que se muestre un mensaje cuando el egresado o los egresados no coincidan con la consulta
    public function testEgresado_MensajeNoHayDatos()
    {
        $response = $this->get(route('egresado.index', ['q' => 'No Match']));
        $response->assertSeeText('No se encontraron resultados');
    }

    public function testEgresado_filtrarIdEgresado(){
        $response = $this->get(route('egresado.index', ['q' => '79444264']));
        $response->assertSeeText('79444264');
    }

    public function testEgresado_filtrarNombreEgresado(){
        $response = $this->get(route('egresado.index', ['q' => '79444264']));
        $response->assertSeeText('Hector Trantow');
    }


    public function testEgresado_filtrarCarrera(){
        $response = $this->get(route('egresado.index', ['q' => '79444264']));
        $response->assertSeeText('Bachillerato en Ciencias y Letras');
    }

    public function testEgresado_filtrarAño(){
        $response = $this->get(route('egresado.index', ['q' => '79444264']));
        $response->assertSeeText('1983');
    }
}
