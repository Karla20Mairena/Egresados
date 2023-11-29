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
            'año_egresado' => '2021', 
            'fecha_nacimiento' => '2001-05-06', 
            'identidad' => '0703200108528',
            'nro_expediente' => '203', 
            'gene_id' => $genero = Genero::inRandomOrder()->first(),
            'carre_id' =>  $carrera = Carrera::inRandomOrder()->first()
        ];

        $response = $this->post('/egresado', $data);
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
            'año_egresado' => $egresado->año_egresado,
            'fecha_nacimiento' => $egresado->fecha_nacimiento,
            'identidad' => $egresado->identidad,
            'nro_expediente' => $egresado->nro_expediente, 
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
