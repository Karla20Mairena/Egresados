<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Genero;
use App\Models\Carrera;
use App\Models\Egresado;
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

        $this->user = User::factory()->create();

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
        $genero = Genero::factory()->create();
        $carrera = Carrera::factory()->create();

        // Datos del egresado a enviar
        $datosEgresado = [
            'nombre' => 'Nombre del Egresado',
            'año_egresado' => 2023,
            'fecha_nacimiento' => '1990-01-01',
            'identidad' => '1234567891234',
            'nro_expediente' => '123',
            'gene_id' => $genero->id,
            'carre_id' => $carrera->id,
        ];

        $response = $this->post('/egresado', [
            'nombre' => 'Juan Pablo Ordoñez Salgado',
            'año_egresado' => 2016,
            'fecha_nacimiento' => '1994-08-15',
            'identidad' => '070319940240',
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
        'identidad' => '070319940240',
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

    public function test_nombre_del_egresado_nulo()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::beginTransaction();
        $data = Egresado::factory()->make([
            'nombre' => null
        ])->toArray();

        $response = $this->post(route('egresado.store'), $data);

        DB::rollBack();

        $response->assertSessionHasErrors('nombre');
    }
    public function test_nombre_del_egresado_correcto()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::beginTransaction();
        $data = Egresado::factory()->make([
            'nombre' => 'Laura Yolany Diaz Sarmiento'
        ])->toArray();

        $response = $this->post(route('egresado.store'), $data);

        DB::rollBack();

        $response->assertSessionHasErrors('nombre');
    }
    
    public function test_nombre_del_egresado_vacio()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::beginTransaction();
        $data = Egresado::factory()->make([
            'nombre' => ''
        ])->toArray();

        $response = $this->post(route('egresado.store'), $data);

        DB::rollBack();

        $response->assertSessionHasErrors('nombre');
    }

    public function test_nombre_solo_letras_y_espacios()
    {
        $validName = 'John Doe'; // Nombre válido

        $egresadoDataValid = Egresado::factory()->make([
            'nombre' => $validName,
        ])->toArray();

        $responseValid = $this->post(route('egresado
        .store'), $egresadoDataValid);

        $responseValid->assertSessionDoesntHaveErrors('nombre');
    }

    public function test_nombre_del_egresado_numerico()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::beginTransaction();
        $data = Egresado::factory()->make([
            'nombre' => '1234567891011123'
        ])->toArray();

        $response = $this->post(route('egresado.store'), $data);

        DB::rollBack();

        $response->assertSessionHasErrors('nombre');
    }

    public function test_nombre_del_egresado_muy_extenso()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::beginTransaction();
        $data = Egresado::factory()->make([
            'nombre' => 'Sara Leonor Perez Arguijo de Lovo Santos Flores de Padilla Gonzalez Sara Leonor'
        ])->toArray();

        $response = $this->post(route('egresado.store'), $data);

        DB::rollBack();

        $response->assertSessionHasErrors('nombre');
    }

    public function test_nombre_del_egresado_muy_corto()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::beginTransaction();
        $data = Egresado::factory()->make([
            'nombre' => 'Sara Leonor Perez Arguijo de Lovo Santos Flores de Padilla Gonzalez Sara Leonor'
        ])->toArray();

        $response = $this->post(route('egresado.store'), $data);

        DB::rollBack();

        $response->assertSessionHasErrors('nombre');
    }

    public function test_nombre_del_egresado_con_letras_y_numeros()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::beginTransaction();
        $data = Egresado::factory()->make([
            'nombre' => 'S4r4 L30n0r P3R35'
        ])->toArray();

        $response = $this->post(route('egresado.store'), $data);

        DB::rollBack();

        $response->assertSessionHasErrors('nombre');
    }

    public function test_nombre_del_egresado_con_caracteres_especiales()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::beginTransaction();
        $data = Egresado::factory()->make([
            'nombre' => '@@%$#&*@@%$&%%#'
        ])->toArray();

        $response = $this->post(route('egresado.store'), $data);

        DB::rollBack();

        $response->assertSessionHasErrors('nombre');
    }

    public function test_año_egresado_del_egresado_nulo()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::beginTransaction();
        $data = Egresado::factory()->make([
            'año_egresado' => null
        ])->toArray();

        $response = $this->post(route('egresado.store'), $data);

        DB::rollBack();

        $response->assertSessionHasErrors('año_egresado');
    }

    public function test_año_egresado_del_egresado_con_letras()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::beginTransaction();
        $data = Egresado::factory()->make([
            'año_egresado' => 'abcdefghijlmnkopqrstuvwxyz'
        ])->toArray();

        $response = $this->post(route('egresado.store'), $data);

        DB::rollBack();

        $response->assertSessionHasErrors('año_egresado');
    }

    public function test_año_egresado_del_egresado_con_caracteres_especiales()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::beginTransaction();
        $data = Egresado::factory()->make([
            'año_egresado' => '@#$#%$#%##$#@#$'
        ])->toArray();

        $response = $this->post(route('egresado.store'), $data);

        DB::rollBack();

        $response->assertSessionHasErrors('año_egresado');
    }
    
    public function test_año_egresado_del_egresado_vacio()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::beginTransaction();
        $data = Egresado::factory()->make([
            'año_egresado' => ''
        ])->toArray();

        $response = $this->post(route('egresado.store'), $data);

        DB::rollBack();

        $response->assertSessionHasErrors('año_egresado');
    }

    public function test_año_egresado_mayor_a_la_fecha_nacimiento()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::beginTransaction();
        $data = Egresado::factory()->make([
            'año_egresado' => '2020',
            'fecha_nacimiento'  => '1992-10-16'

        ])->toArray();

        $response = $this->post(route('egresado.store'), $data);

       // Verificar que la respuesta sea exitosa 
       $response->assertSuccessful();

       DB::rollBack();
    }

    public function test_año_egresado_menor_a_la_fecha_nacimiento()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::beginTransaction();
        $data = Egresado::factory()->make([
            'año_egresado' => '2020',
            'fecha_nacimiento'  => '2023-10-16'

        ])->toArray();

        $response = $this->post(route('egresado.store'), $data);

        DB::rollBack();

        $response->assertSessionHasErrors('año_egresado');
    }

    public function test_fecha_nacimiento_null()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::beginTransaction();
        $data = Egresado::factory()->make([
            'fecha_nacimiento'  => null

        ])->toArray();

        $response = $this->post(route('egresado.store'), $data);

        DB::rollBack();

        $response->assertSessionHasErrors('fecha_nacimiento');
    }

    public function test_fecha_nacimiento_vacio()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::beginTransaction();
        $data = Egresado::factory()->make([
            'fecha_nacimiento'  => ''

        ])->toArray();

        $response = $this->post(route('egresado.store'), $data);

        DB::rollBack();

        $response->assertSessionHasErrors('fecha_nacimiento');
    }

    public function test_formato_fecha_nacimiento()
    {
        $invalidDate = '15-2022-40'; // Ejemplo de fecha con formato incorrecto

        $egresadoData = Egresado::factory()->make([
            'fecha_nacimiento' => $invalidDate,
        ])->toArray();

        $response = $this->post(route('egresados.store'), $egresadoData);

        $response->assertSessionHasErrors('fecha_nacimiento');
    }

    public function test_fecha_nacimiento_formato_fecha_no_valido()
    {
        $invalidDate = '2022-02-31'; // Fecha inválida (febrero no tiene 31 días)

        $egresadoData = Egresado::factory()->make([
            'fecha_nacimiento' => $invalidDate,
        ])->toArray();

        $response = $this->post(route('egresado.store'), $egresadoData);

        $response->assertSessionHasErrors('fecha_nacimiento');
    }


    //Considerando años biciestos y no biciestos
    public function test_fecha_nacimiento_meses_validos()
    {
        $invalidLeapYearDate = '2023-02-29'; // Fecha inválida en un año no bisiesto

        $egresadoData = Egresado::factory()->make([
            'fecha_nacimiento' => $invalidLeapYearDate,
        ])->toArray();

        $response = $this->post(route('egresados.store'), $egresadoData);

        $response->assertSessionHasErrors('fecha_nacimiento');
    }

    public function test_fecha_nacimiento_año_bisiesto()
    {
        $leapYearDate = '2024-02-29'; // Fecha válida en un año bisiesto

        $egresadoData = Egresado::factory()->make([
            'fecha_nacimiento' => $leapYearDate,
        ])->toArray();

        $response = $this->post(route('egresados.store'), $egresadoData);

        $response->assertSessionDoesntHaveErrors('fecha_nacimiento');
    }

    public function test_fecha_nacimiento_con_letras()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::beginTransaction();
        $data = Egresado::factory()->make([
            'fecha_nacimiento'  => 'abcdefghijklmnopqrstuvwxyz'

        ])->toArray();

        $response = $this->post(route('egresado.store'), $data);

        DB::rollBack();

        $response->assertSessionHasErrors('fecha_nacimiento');
    }

    public function test_fecha_nacimiento_con_caracteres_especiales()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::beginTransaction();
        $data = Egresado::factory()->make([
            'fecha_nacimiento'  => '@##$%#$#$#$#$#$%@@'

        ])->toArray();

        $response = $this->post(route('egresado.store'), $data);

        DB::rollBack();

        $response->assertSessionHasErrors('fecha_nacimiento');
    }

    public function test_fecha_nacimiento_mayor_año_egresado()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::beginTransaction();
        $data = Egresado::factory()->make([
            'fecha_nacimiento'  => '2023-04-15',
            'año_egresado'  => '2015'

        ])->toArray();

        $response = $this->post(route('egresado.store'), $data);

        DB::rollBack();

        $response->assertSessionHasErrors('fecha_nacimiento');
    }

    public function test_fecha_nacimiento_menor_año_egresado()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::beginTransaction();
        $data = Egresado::factory()->make([
            'fecha_nacimiento'  => '2004-04-15',
            'año_egresado'  => '2022'

        ])->toArray();

        $response = $this->post(route('egresado.store'), $data);

       // Verificar que la respuesta sea exitosa 
       $response->assertSuccessful();

       DB::rollBack();
    }

    public function test_indentidad_null()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::beginTransaction();
        $data = Egresado::factory()->make([
            'identidad'  => null
        ])->toArray();

        $response = $this->post(route('egresado.store'), $data);

        DB::rollBack();

        $response->assertSessionHasErrors('identidad');
    }

    public function test_indentidad_vacio()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::beginTransaction();
        $data = Egresado::factory()->make([
            'identidad'  => ''
        ])->toArray();

        $response = $this->post(route('egresado.store'), $data);

        DB::rollBack();

        $response->assertSessionHasErrors('identidad');
    }


    //Esta prueba verifica que el formato de identidad sea ####-####-#####
    public function test_indentidad_fuera_de_formato()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::beginTransaction();
        $data = Egresado::factory()->make([
            'identidad'  => '0703451-122512647-52314300'
        ])->toArray();

        $response = $this->post(route('egresado.store'), $data);

        DB::rollBack();

        $response->assertSessionHasErrors('identidad');
    }

    public function test_indentidad_con_letras()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::beginTransaction();
        $data = Egresado::factory()->make([
            'identidad'  => 'abcdefghijlmnopqastceus'
        ])->toArray();

        $response = $this->post(route('egresado.store'), $data);

        DB::rollBack();

        $response->assertSessionHasErrors('identidad');
    }

    public function test_indentidad_sin_guiones()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::beginTransaction();
        $data = Egresado::factory()->make([
            'identidad'  => '0703199802847'
        ])->toArray();

        $response = $this->post(route('egresado.store'), $data);

        DB::rollBack();

        $response->assertSessionHasErrors('identidad');
    }

    public function test_indentidad_con_guiones()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::beginTransaction();
        $data = Egresado::factory()->make([
            'identidad'  => '0703-1998-02847'
        ])->toArray();

        $response = $this->post(route('egresado.store'), $data);

        // Verificar que la respuesta sea exitosa 
       $response->assertSuccessful();

       DB::rollBack();
    }


    //Esta es una prueba para verificar que el numero de identidad solo pueda comenzar con 0 o con 1
    public function test_indentidad_con_cualquier_numero()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::beginTransaction();
        $data = Egresado::factory()->make([
            'identidad'  => '7895-1785-02418'
        ])->toArray();

        $response = $this->post(route('egresado.store'), $data);

        DB::rollBack();

        $response->assertSessionHasErrors('identidad');
    }

    //Esta es una prueba para verificar que el numero de identidad solo pueda comenzar con 0 o con 1
    //SIN GUIONES
    public function test_indentidad_con_cualquier_numero_sin_guiones()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::beginTransaction();
        $data = Egresado::factory()->make([
            'identidad'  => '7895178502418'
        ])->toArray();

        $response = $this->post(route('egresado.store'), $data);

        DB::rollBack();

        $response->assertSessionHasErrors('identidad');
    }

    public function test_gene_id_debe_existir_en_tabla_generos()
    {
        $generoNoExistenteId = 999; // Suponiendo un ID que no existe en la tabla Genero

        $egresadoData = Egresado::factory()->make([
            'gene_id' => $generoNoExistenteId,
        ])->toArray();

        $response = $this->post(route('egresado.store'), $egresadoData);

        $response->assertSessionHasErrors('gene_id');
    }

    public function test_carre_id_debe_existir_en_tabla_carreras()
    {
        $carreraNoExistenteId = 999; // Suponiendo un ID que no existe en la tabla Carrera

        $egresadoData = Egresado::factory()->make([
            'carre_id' => $carreraNoExistenteId,
        ])->toArray();

        $response = $this->post(route('egresado.store'), $egresadoData);

        $response->assertSessionHasErrors('carre_id');
    }

    public function test_gene_id_no_puede_ser_vacio()
    {
        $egresadoData = Egresado::factory()->make([
            'gene_id' => null, // Gene ID vacío
        ])->toArray();

        $response = $this->post(route('egresado.store'), $egresadoData);

        $response->assertSessionHasErrors('gene_id');
    }

    public function test_carre_id_no_puede_ser_vacio()
    {
        $egresadoData = Egresado::factory()->make([
            'carre_id' => null, // Carrera ID vacío
        ])->toArray();

        $response = $this->post(route('egresado.store'), $egresadoData);

        $response->assertSessionHasErrors('carre_id');
    }

    public function test_solo_un_genero_puede_ser_seleccionado()
    {
        $generos = Genero::all();

        $egresadoData = Egresado::factory()->make([
            'gene_id' => $generos->random()->id,
        ])->toArray();

        $response = $this->post(route('egresado.store'), $egresadoData);

        // Verificar que no hay errores
        $response->assertSessionDoesntHaveErrors('gene_id');
    }

    public function test_solo_una_carrera_puede_ser_seleccionada()
    {
        $carreras = Carrera::all();

        $egresadoData = Egresado::factory()->make([
            'carre_id' => $carreras->random()->id,
        ])->toArray();

        $response = $this->post(route('egresado.store'), $egresadoData);

        // Verificar que no hay errores
        $response->assertSessionDoesntHaveErrors('carre_id');
    }
    public function test_seleccionar_mas_de_un_genero_deberia_fallar()
    {
        $generos = Genero::limit(2)->get(); // Obtener dos géneros

        $egresadoData = Egresado::factory()->make([
            'gene_id' => $generos->pluck('id')->toArray(),
        ])->toArray();

        $response = $this->post(route('egresado.store'), $egresadoData);

        // Verificar que la validación falle para gene_id
        $response->assertSessionHasErrors('gene_id');
    }

    public function test_seleccionar_mas_de_una_carrera_deberia_fallar()
    {
        $carreras = Carrera::limit(2)->get(); // Obtener dos géneros

        $egresadoData = Egresado::factory()->make([
            'carre_id' => $carreras->pluck('id')->toArray(),
        ])->toArray();

        $response = $this->post(route('egresado.store'), $egresadoData);

        // Verificar que la validación falle para gene_id
        $response->assertSessionHasErrors('carre_id');
    }

    public function test_numero_expediente_debe_ser_unico()
    {
        $existingExpediente = Egresado::factory()->create()->nro_expediente;

        $egresadoData = Egresado::factory()->make([
            'nro_expediente' => $existingExpediente,
        ])->toArray();

        $response = $this->post(route('egresado.store'), $egresadoData);

        $response->assertSessionHasErrors('nro_expediente');
    }

    public function test_nombre_debe_ser_unico()
    {
        $existingExpediente = Egresado::factory()->create()->nombre;

        $egresadoData = Egresado::factory()->make([
            'nombre' => $existingExpediente,
        ])->toArray();

        $response = $this->post(route('egresado.store'), $egresadoData);

        $response->assertSessionHasErrors('nombre');
    }

    public function test_identidad_debe_ser_unico()
    {
        $existingExpediente = Egresado::factory()->create()->identidad;

        $egresadoData = Egresado::factory()->make([
            'identidad' => $existingExpediente,
        ])->toArray();

        $response = $this->post(route('egresado.store'), $egresadoData);

        $response->assertSessionHasErrors('identidad');
    }

    public function test_numero_expediente_no_debe_estar_vacio()
    {
        $egresadoData = Egresado::factory()->make([
            'nro_expediente' => '', // Número de expediente vacío
        ])->toArray();

        $response = $this->post(route('egresado.store'), $egresadoData);

        $response->assertSessionHasErrors('nro_expediente');
    }

    public function test_nro_expediente_muy_extenso()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::beginTransaction();
        $data = Egresado::factory()->make([
            'nro_expediente' => '12458411615414101615497461649884'
        ])->toArray();

        $response = $this->post(route('egresado.store'), $data);

        DB::rollBack();

        $response->assertSessionHasErrors('nro_expediente');
    }

    public function test_nro_expediente_con_letras()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::beginTransaction();
        $data = Egresado::factory()->make([
            'nro_expediente' => 'seis cientos cincuenta'
        ])->toArray();

        $response = $this->post(route('egresado.store'), $data);

        DB::rollBack();

        $response->assertSessionHasErrors('nro_expediente');
    }

    public function test_nro_expediente_con_caracteres_especiales()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::beginTransaction();
        $data = Egresado::factory()->make([
            'nro_expediente' => '@@###%#%#$$#'
        ])->toArray();

        $response = $this->post(route('egresado.store'), $data);

        DB::rollBack();

        $response->assertSessionHasErrors('nro_expediente');
    }

    public function test_nro_expediente_con_letras_y_numeros()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        DB::beginTransaction();
        $data = Egresado::factory()->make([
            'nro_expediente' => 'ABC123'
        ])->toArray();

        $response = $this->post(route('egresado.store'), $data);

        DB::rollBack();

        $response->assertSessionHasErrors('nro_expediente');
    }

}




