<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Egresado;
use App\Models\Genero;
use App\Models\Carrera;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class EditarEgresadoTest extends TestCase
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

    //Esta es una prueba que verifica si la página que contiene el formulario de editar egresados está disponible y devuelve un 
    //código de estado HTTP 200.
    public function testEditFormIsAvailable()
    {
        $response = $this->get('/egresado/edit');
        $response->assertStatus(200);
    }

    public function testActualizarEgresado()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::beginTransaction();
        $egresado = Egresado::factory()->create();
        $data = ['nombre' => 'Nombre Actualizado'];

        $response = $this->put("/egresado/{$egresado->id}", $data);
        DB::rollBack();
        $response->assertStatus(302); 
    }

    public function testNombreEgresadoNull()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $egresado = Egresado::factory()->create();
        $data = Egresado::factory()->make(['nombre' => null])->toArray();

        $response = $this->put("/egresado/{$egresado->id}", $data);

        $response->assertSessionHasErrors('nombre');
    }

    //Esta función prueba que un usuario puede actualizar un egresado existente correctamente.
    public function test_EditarEgresadoCorrectamente()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $this->withoutExceptionHandling();
        $egresado = Egresado::first();
        DB::beginTransaction();

        $response = $this->put("/egresado/{$egresado->id}", [
            'nombre' => 'Egresado Test',
            'fecha_nacimiento' => '1996',
            'fecha_nacimiento' => '2000-09-24',
            'identidad' => '0703195002489',
            'nro_expediente' => '16',
            'gene_id' => function () {
                return Genero::inRandomOrder()->first()->id;
            },
            'carre_id' => function () {
                return Carrera::inRandomOrder()->first()->id;
            }, 
        ]);

        DB::rollBack();
        $response->assertRedirect('/egresado');
    }

    public function test_ActualizarEgresadoInexistente()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $this->withoutExceptionHandling();
        $egresado = Egresado::first();
        DB::beginTransaction();


        $response = $this->put("/egresado/{$egresado->id}", [
            'nombre' => 'EgresadoProximo',
            'fecha_nacimiento' => '1970',
            'fecha_nacimiento' => '2000-09-10',
            'identidad' => '1212132312313',
            'nro_expediente' => '16',
            'gene_id' => function () {
                return Genero::inRandomOrder()->first()->id;
            },
            'carre_id' => function () {
                return Carrera::inRandomOrder()->first()->id;
            }, 
        ]);

        $response->assertNotFound();
    }

    //Pueba de actualizar con campos vacios
    public function test_validacionCamposVacios()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $response = $this->put("/egresado/20", []);
        $response->assertSessionHasErrors(['nombre', 'fecha_nacimiento', 'fecha_nacimiento', 'identidad', 'nro_expediente',
        'gene_id', 'carre_id' ]);
    }

    public function testRedireccionCorrectaDespuesDeActualizarEgresado()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::beginTransaction();
        $egresado = Egresado::factory()->create();
        $data = ['nombre' => 'Nombre Actualizado'];

        $response = $this->put("/egresado/{$egresado->id}", $data);
        DB::rollBack();
        $response->assertStatus(302); // O verificar si redirige a una URL específica
    }

    public function testNombreEgresadoNumerico()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $egresado = Egresado::factory()->create();
        $data = Egresado::factory()->make(['nombre' => '12345',])->toArray();

        $response = $this->put("/egresado/{$egresado->id}", $data);

        $response->assertSessionHasErrors('nombre');
    }

    public function testNombreEgresadoVacio()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $egresado = Egresado::factory()->create();
        $data = Egresado::factory()->make(['nombre' => ' '])->toArray();

        $response = $this->put("/egresado/{$egresado->id}", $data);

        $response->assertSessionHasErrors('nombre');
    }


    public function testNombreEgresadoExtenso()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $egresado = Egresado::factory()->create();
        $data = Egresado::factory()->make(['nombre' => 'Nolvia Gisella Rodriguez Lazo de Sorto Flores Gonzalez Hernandez',])->toArray();

        $response = $this->put("/egresado/{$egresado->id}", $data);

        $response->assertSessionHasErrors('nombre');
    }

    public function testNombreEgresadoCorto()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $egresado = Egresado::factory()->create();
        $data = Egresado::factory()->make(['nombre' => 'N',])->toArray();

        $response = $this->put("/egresado/{$egresado->id}", $data);

        $response->assertSessionHasErrors('nombre');
    }

    public function testNombreEgresadoConDobleEspaciado()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $egresado = Egresado::factory()->create();
        $data = Egresado::factory()->make(['nombre' => '  Nolvia  Gisella  Rodriguez  Lazo  ',])->toArray();

        $response = $this->put("/egresado/{$egresado->id}", $data);

        $response->assertSessionHasErrors('nombre');
    }

    public function testNombreEgresadoConLetraYnumero()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $egresado = Egresado::factory()->create();
        $data = Egresado::factory()->make(['nombre' => 'N0lv14 L0p3z S0l0rz4n0',])->toArray();

        $response = $this->put("/egresado/{$egresado->id}", $data);

        $response->assertSessionHasErrors('nombre');
    }

    public function testNombreEgresadoConAñoEnLetras()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $egresado = Egresado::factory()->create();
        $data = Egresado::factory()->make(['fecha_nacimiento' => 'dos mil nueve',])->toArray();

        $response = $this->put("/egresado/{$egresado->id}", $data);

        $response->assertSessionHasErrors('fecha_nacimiento');
    }

    public function testNombreEgresadoConAñoMayorAlActual()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $egresado = Egresado::factory()->create();
        $data = Egresado::factory()->make(['fecha_nacimiento' => '2028',])->toArray();

        $response = $this->put("/egresado/{$egresado->id}", $data);

        $response->assertSessionHasErrors('fecha_nacimiento');
    }

    public function testNombreEgresadoConAñoNumerico()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $egresado = Egresado::factory()->create();
        $data = Egresado::factory()->make(['fecha_nacimiento' => '2009',])->toArray();

        $response = $this->put("/egresado/{$egresado->id}", $data);

        $response->assertSessionHasErrors('fecha_nacimiento');
    }

    public function testNombreEgresadoConFechaNacimientoEnLetras()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $egresado = Egresado::factory()->create();
        $data = Egresado::factory()->make(['fecha_nacimiento' => '09 de enero de 1994',])->toArray();

        $response = $this->put("/egresado/{$egresado->id}", $data);

        $response->assertSessionHasErrors('fecha_nacimiento');
    }









}