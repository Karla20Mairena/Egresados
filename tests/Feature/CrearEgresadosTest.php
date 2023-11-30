<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Genero;
use App\Models\Carrera;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CrearEgresadosTest extends TestCase
{

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Busqueda de el usuario en la base de datos por medio de correo electrónico
        $this->user = User::where('correo', 'cosme@gmail.com')->first();
        // Si  no se encuentra el usuario, debe lanzar un error
        if (!$this->user) {
            $this->fail('Usuario no encontrado');
        }
        // Actuando como el usuario encontrado
        $this->actingAs($this->user);
    }

    //Esta es una prueba que verifica si la página que contiene el formulario de crear egresados está disponible y devuelve un 
    //código de estado HTTP 200.
    public function testCreateFormIsAvailable()
    {
        $response = $this->get('/egresado/create');
        $response->assertStatus(200);
    }
    //Esta prueba verifica si se puede crear un nuevo egresado solicitando una solicitud post para confirmar la redireccion 
    //a la pagina principal
    public function test_CrearUnEgresado()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $this->withoutExceptionHandling();

        // Crear un genero y una carrera para asociar al egresado
        $genero = factory(Genero::class)->create();
        $carrera = factory(Carrera::class)->create();

        // Datos del egresado a enviar
        $datosEgresado = [
            'nombre' => 'Nombre del Egresado',
            'año_egresado' => '2023',
            'fecha_nacimiento' => '1990-01-01',
            'identidad' => '123456789',
            'nro_expediente' => 'EX-123',
            'gene_id' => $genero->id,
            'carre_id' => $carrera->id,
        ];

        $response = $this->post('/egresado', [
            'nombre' => 'Juan Pablo Ordoñez Salgado',
            'año_egresado' => '2016',
            'fecha_nacimiento' => '1994-08-15',
            'identidad' => '07031994024064',
            'nro_expediente' => '10',
            'gene_id' => Genero::first()->id ,
            'carre_id' =>  Carrera::first()->id , 
            
        ]);

        // Envía una solicitud POST a la ruta de creación de egresados
        $response = $this->post('/egresado', $datosEgresado);

        // Verifica si el egresado se almacenó en la base de datos
        $response->assertStatus(302); // Redirección después de crear
        $this->assertDatabaseHas('egresados', ['nombre' => 'Juan Pablo Ordoñez Salgado',
        'año_egresado' => '2016',
        'fecha_nacimiento' => '1994-08-15',
        'identidad' => '07031994024064',
        'nro_expediente' => '10',
        'gene_id' => Genero::first()->id ,
        'carre_id' =>  Carrera::first()->id]);

        DB::rollBack();
    }
    
    //Esta prueba verifica la validacion de los campos al ir vacios
    public function test_campos_vacios()
    {
        $datosEgresado = [
            'nombre' => '',
            'año_egresado' => '',
            'fecha_nacimiento' => '',
            'identidad' => '',
            'nro_expediente' => '',
            'gene_id' => '',
            'carre_id' => '',
        ];
    
        $response = $this->post('/egresado', $datosEgresado);
    
        $response->assertSessionHasErrors([
            'nombre', 'año_egresado', 'fecha_nacimiento',
            'identidad', 'nro_expediente', 'gene_id', 'carre_id'
        ]);
    }
    
}

