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

    public function test_puede_actualizar_egresado()
    {
        $egresado = Egresado::factory()->create();

        $genero = Genero::factory()->create();
        $carrera = Carrera::factory()->create();

        $newData = [
            'nombre' => $this->faker->name,
            'año_egresado' => $this->faker->year,
            'fecha_nacimiento' => $this->faker->date,
            'identidad' => $this->faker->numerify('#############'),
            'nro_expediente' => $this->faker->randomNumber(5),
            'gene_id' => $genero->id,
            'carre_id' => $carrera->id,
        ];

        $response = $this->put("/egresado/{$egresado->id}", $newData);

        $response->assertRedirect('/egresado')
            ->assertSessionHas('mensaje', 'El egresado fue modificado exitosamente.');

        $this->assertDatabaseHas('egresados', $newData);
    }

    public function test_requiere_todos_los_campos_requeridos_para_actualizar()
{
    $egresado = Egresado::factory()->create();

    $response = $this->put("/egresado/{$egresado->id}", []);

    $response->assertSessionHasErrors(['nombre', 'año_egresado' , 'fecha_nacimiento', 
    'identidad' , 'nro_expediente', 'gene_id', 'carre_id']);
}

public function test_limite_fecha_nacimiento()
{
    $egresado = Egresado::factory()->create();

    // Introducir una fecha fuera del rango permitido
    $data = [
        'fecha_nacimiento' => date('Y-m-d', strtotime('-150 years')), // Fuera del rango permitido
    ];

    $response = $this->put("/egresado/{$egresado->id}", $data);

    $response->assertSessionHasErrors('fecha_nacimiento');
}

public function test_puede_actualizar_con_campos_nulos()
{
    $egresado = Egresado::factory()->create();

    $data = [
        'nombre' => null,
        'año_egresado' => null,
        'fecha_nacimiento' => null,
        'identidad' => null,
        'nro_expediente' => null,
        'gene_id' => null,
        'carre_id' => null,
    ];

    $response = $this->put("/egresado/{$egresado->id}", $data);

    $response->assertRedirect('/egresado')
        ->assertSessionHas('mensaje', 'El egresado fue modificado exitosamente.');

    // Verificar que los campos se hayan actualizado como NULL en la base de datos
    $this->assertDatabaseHas('egresados', [
        'nombre' => null,
        'año_egresado' => null,
        'fecha_nacimiento' => null,
        'identidad' => null,
        'nro_expediente' => null,
        'gene_id' => null,
        'carre_id' => null,
    ]);
}

public function test_actualizar_identidad_formato_invalido()
{
    $egresado = Egresado::factory()->create();

    // Datos con formatos incorrectos
    $data = [
        'identidad' => '1234567890', // Formato incorrecto
    ];

    $response = $this->put("/egresado/{$egresado->id}", $data);

    $response->assertSessionHasErrors(['identidad']);
}

public function test_actualizar_identidad_sin_guiones()
{
    $egresado = Egresado::factory()->create();

    // Datos con formatos incorrectos
    $data = [
        'identidad' => '0703199802418', // Formato incorrecto
    ];

    $response = $this->put("/egresado/{$egresado->id}", $data);

    $response->assertSessionHasErrors(['identidad']);
}

public function test_actualizar_identidad_sin_guiones_con_espacios()
{
    $egresado = Egresado::factory()->create();

    // Datos con formatos incorrectos
    $data = [
        'identidad' => '0703 1998 02418', // Formato incorrecto
    ];

    $response = $this->put("/egresado/{$egresado->id}", $data);

    $response->assertSessionHasErrors(['identidad']);
}


public function test_actualizar_identidad_formato_valido()
{
    $egresado = Egresado::factory()->create();

    // Datos con formatos incorrectos
    $data = [
        'identidad' => '0703-1998-02418', // Formato incorrecto
    ];

    $response = $this->put("/egresado/{$egresado->id}", $data);

    $response->assertSessionHasErrors(['identidad']);
}

public function test_actualizar_identidad_con_letras()
{
    $egresado = Egresado::factory()->create();

    // Datos con formatos incorrectos
    $data = [
        'identidad' => 'abcdefghik', // Formato incorrecto
    ];

    $response = $this->put("/egresado/{$egresado->id}", $data);

    $response->assertSessionHasErrors(['identidad']);
}

public function test_actualizar_identidad_con_caracteres_especiales()
{
    $egresado = Egresado::factory()->create();

    // Datos con formatos incorrectos
    $data = [
        'identidad' => '12@$#%$%', // Formato incorrecto
    ];

    $response = $this->put("/egresado/{$egresado->id}", $data);

    $response->assertSessionHasErrors(['identidad']);
}

public function test_actualizar_identidad_vacio()
{
    $egresado = Egresado::factory()->create();

    // Datos con formatos incorrectos
    $data = [
        'identidad' => '', // Formato vacio
    ];

    $response = $this->put("/egresado/{$egresado->id}", $data);

    $response->assertSessionHasErrors(['identidad']);
}


public function test_actualizar_numero_expediente_con_letras()
{
    $egresado = Egresado::factory()->create();

    $data = [
        'nro_expediente' => 'abcde', // Formato incorrecto
    ];

    $response = $this->put("/egresado/{$egresado->id}", $data);

    $response->assertSessionHasErrors(['nro_expediente']);
}

public function test_actualizar_numero_expediente_extenso()
{
    $egresado = Egresado::factory()->create();

    $data = [
        'nro_expediente' => '1234567891011', // Formato incorrecto
    ];

    $response = $this->put("/egresado/{$egresado->id}", $data);

    $response->assertSessionHasErrors(['nro_expediente']);
}

public function test_actualizar_numero_expediente_corto()
{
    $egresado = Egresado::factory()->create();

    $data = [
        'nro_expediente' => '1', // Formato incorrecto
    ];

    $response = $this->put("/egresado/{$egresado->id}", $data);

    $response->assertSessionHasErrors(['nro_expediente']);
}

public function test_actualizar_numero_expediente_con_caracteres_especiales()
{
    $egresado = Egresado::factory()->create();

    $data = [
        'nro_expediente' => '@#$$%%#$', // Formato incorrecto
    ];

    $response = $this->put("/egresado/{$egresado->id}", $data);

    $response->assertSessionHasErrors(['nro_expediente']);
}

public function test_actualizar_numero_expediente_vacio()
{
    $egresado = Egresado::factory()->create();

    // Datos con formatos incorrectos
    $data = [
        'nro_expediente' => '', // Formato vacio
    ];

    $response = $this->put("/egresado/{$egresado->id}", $data);

    $response->assertSessionHasErrors(['nro_expediente']);
}


public function test_limite_año_egresado()
{
    $egresado = Egresado::factory()->create();

    // Introducir un año fuera del rango permitido
    $data = [
        'año_egresado' => date('Y') + 2, // Año en el futuro
    ];

    $response = $this->put("/egresado/{$egresado->id}", $data);

    $response->assertSessionHasErrors('año_egresado');
}

public function test_año_egresado_vacio()
{
    $egresado = Egresado::factory()->create();

    // Introducir un año fuera del rango permitido
    $data = [
        'año_egresado' => '', // Año egresado
    ];

    $response = $this->put("/egresado/{$egresado->id}", $data);

    $response->assertSessionHasErrors('año_egresado');
}

public function test_año_egresado_con_letras()
{
    $egresado = Egresado::factory()->create();

    // Introducir un año fuera del rango permitido
    $data = [
        'año_egresado' => 'ABC', // Año egresado con letras (invalido)
    ];

    $response = $this->put("/egresado/{$egresado->id}", $data);

    $response->assertSessionHasErrors('año_egresado');
}

public function test_año_egresado_con_caracteres_especiales()
{
    $egresado = Egresado::factory()->create();

    // Introducir un año fuera del rango permitido
    $data = [
        'año_egresado' => '@@#$$%%$', // Año egresado (invalido)
    ];

    $response = $this->put("/egresado/{$egresado->id}", $data);

    $response->assertSessionHasErrors('año_egresado');
}

public function test_puede_actualizar_con_datos_validos()
{
    
    $egresado = Egresado::factory()->create();

    $genero = Genero::factory()->create();
    $carrera = Carrera::factory()->create();

    $data = [
        'nombre' => $this->faker->name,
        'año_egresado' => $this->faker->year,
        'fecha_nacimiento' => $this->faker->date,
        'identidad' => $this->faker->numerify('#############'),
        'nro_expediente' => $this->faker->randomNumber(5),
        'gene_id' => $genero->id,
        'carre_id' => $carrera->id,
    ];

    $response = $this->put("/egresado/{$egresado->id}", $data);

    $response->assertRedirect('/egresado')
        ->assertSessionHas('mensaje', 'El egresado fue modificado exitosamente.');

    $this->assertDatabaseHas('egresados', $data);
}


public function test_actualizar_egresado_inexistente()
{
    $nonExistingId = 9999; // Un ID que no existe

    $response = $this->put("/egresado/{$nonExistingId}", []);

    $response->assertNotFound();
}

public function test_actualizar_con_campos_minimos_requeridos()
{
    $egresado = Egresado::factory()->create();

    $data = [
        'nombre' => 'Josue Mencias Alvarado', // Nombre válido
        'año_egresado' => date('Y') - 10, // Año de egreso válido
        'gene_id' => Genero::factory()->create()->id, // ID de género válido
        'carre_id' => Carrera::factory()->create()->id, // ID de carrera válida
    ];

    $response = $this->put("/egresado/{$egresado->id}", $data);

    $response->assertRedirect('/egresado')
        ->assertSessionHas('mensaje', 'El egresado fue modificado exitosamente.');

    $this->assertDatabaseHas('egresados', $data);
}

public function test_actualizar_fecha_nacimiento_en_rango_permitido()
{
    $egresado = Egresado::factory()->create();

    // Fecha de nacimiento dentro del rango permitido
    $validDateOfBirth = date('Y-m-d', strtotime('-25 years'));

    $data = [
        'fecha_nacimiento' => $validDateOfBirth,
    ];

    $response = $this->put("/egresado/{$egresado->id}", $data);

    $response->assertRedirect('/egresado')
        ->assertSessionHas('mensaje', 'El egresado fue modificado exitosamente.');

    $this->assertDatabaseHas('egresados', ['fecha_nacimiento' => $validDateOfBirth]);
}


public function test_actualizar_con_genero_inexistente()
{
    $egresado = Egresado::factory()->create();

    // IDs inexistentes de género y carrera
    $nonExistingGenderId = 9999;

    $data = [
        'gene_id' => $nonExistingGenderId,
    ];

    $response = $this->put("/egresado/{$egresado->id}", $data);

    $response->assertSessionHasErrors(['gene_id']);
}

public function test_actualizar_con_carrera_inexistente()
{
    $egresado = Egresado::factory()->create();

    // IDs inexistentes de género y carrera
    $nonExistingCarreerId = 9999;

    $data = [
        'carre_id' =>  $nonExistingCarreerId ,
    ];

    $response = $this->put("/egresado/{$egresado->id}", $data);

    $response->assertSessionHasErrors(['carre_id']);
}

public function test_actualizar_con_genero_existente()
{
    $egresado = Egresado::factory()->create();

    $existingGenero = Genero::factory()->create();

    $data = [
        'gene_id' => $existingGenero->id,
    ];

    $response = $this->put("/egresado/{$egresado->id}", $data);

    $response->assertRedirect('/egresado')
        ->assertSessionHas('mensaje', 'El egresado fue modificado exitosamente.');

    $this->assertDatabaseHas('egresados', $data);
}

public function test_actualizar_con_carrera_existente()
{
    $egresado = Egresado::factory()->create();

    $existingCarrera = Carrera::factory()->create();

    $data = [
        'carre_id' => $existingCarrera->id,
    ];

    $response = $this->put("/egresado/{$egresado->id}", $data);

    $response->assertRedirect('/egresado')
        ->assertSessionHas('mensaje', 'El egresado fue modificado exitosamente.');

    $this->assertDatabaseHas('egresados', $data);
}

public function test_fecha_nacimiento_vacia_y_año_egresado_invalido()
{
    $egresado = Egresado::factory()->create();

    $data = [
        'fecha' => '', // Fecha de nacimiento vacía
        'año_egresado' => date('Y') + 5, // Año de egreso inválido (en el futuro)
    ];

    $response = $this->put("/egresado/{$egresado->id}", $data);

    $response->assertSessionHasErrors(['fecha_nacimiento', 'año_egresado']);
}

public function test_actualizar_año_egresado_menor_a_fecha_nacimiento()
{
    $egresado = Egresado::factory()->create();

    $data = [
        'fecha_nacimiento' => '', // Fecha de nacimiento vacía
        'año_egresado' => date('Y') + 5, // Año de egreso inválido (en el futuro)
    ];

    $response = $this->put("/egresado/{$egresado->id}", $data);

    $response->assertSessionHasErrors(['fecha_nacimiento', 'año_egresado']);
}

public function test_actualizar_fecha_nacimiento_mayor_a_año_egresado()
{
    $egresado = Egresado::factory()->create([
        'fecha_nacimiento' => date('Y-m-d', strtotime('-20 years')), // Fecha de nacimiento válida
        'año_egresado' => date('Y') - 25, // Año de egreso mayor que la fecha de nacimiento
    ]);

    $data = [
        'fecha' => date('Y-m-d', strtotime('-15 years')), // Fecha de nacimiento mayor que el año de egreso
    ];

    $response = $this->put("/egresado/{$egresado->id}", $data);

    $response->assertSessionHasErrors('fecha');
}

}