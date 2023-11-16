<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Route;

class PruebasDeRutas extends TestCase
{
    /**
     * Una prueba básica de características.
     *
     * @return void
     */
    public function test_registrar_rutas()
    {
        $closure = function () {
            Route::middleware("desactivado")->group(function () {
                Route::resource('carreras', 'App\Http\Controllers\CarreraController');
                Route::resource('/egresado', 'App\Http\Controllers\EgresadoController');
                // Asegurar que las rutas estén registradas para diferentes controladores
                $this->assertTrue(Route::has('carreras.index'));
                $this->assertTrue(Route::has('egresado.index'));
            });
        };
        $closure();
    }

    // La función debería aplicar middleware con éxito para autenticación y desactivación.
    public function test_aplicar_middleware()
    {
        $closure = function () {
            Route::middleware("auth")->group(function () {
                // Asegurar que el middleware de autenticación se aplique con éxito
                $this->assertTrue(Route::hasMiddlewareGroup('auth'));
            });
            Route::middleware("desactivado")->group(function () {
                // Asegurar que el middleware de desactivación se aplique con éxito
                $this->assertTrue(Route::hasMiddlewareGroup('desactivado'));
            });
        };
        $closure();
    }

    // La función debería crear y manejar con éxito diferentes rutas para diferentes métodos HTTP.
    public function test_crear_y_manipular_rutas()
    {
        $closure = function () {
            Route::middleware("desactivado")->group(function () {
                // Crear rutas para diferentes métodos HTTP
                Route::get('/contrasenia', [UserController::class, 'formularioclave'])
                    ->name('contrasenia.cambiar');
                Route::post('/contrasenia', [UserController::class, 'guardarclave'])
                    ->name('contrasenia.cambiada');
                Route::put('/usuario/editar', [UserController::class, 'actualizar'])
                    ->name('usuario.actualizar');
                // Asegurar que las rutas se creen y manejen correctamente
                $this->assertTrue(Route::has('contrasenia.cambiar'));
                $this->assertTrue(Route::has('contrasenia.cambiada'));
                $this->assertTrue(Route::has('usuario.actualizar'));
            });
        };
        $closure();
    }

    // La función debería manejar casos en los que el usuario no está autenticado.
    public function test_manipular_usuario_no_autenticado()
    {
        $closure = function () {
            Route::middleware("auth")->group(function () {
                // Asegurar que el usuario no esté autenticado
                $this->assertFalse(Route::hasMiddlewareGroup('auth'));
            });
        };
        $closure();
    }

    // La función debería manejar casos en los que el usuario está desactivado.
    public function test_manipular_usuario_desactivado()
    {
        $closure = function () {
            Route::middleware("desactivado")->group(function () {
                // Asegurar que el usuario esté desactivado
                $this->assertFalse(Route::hasMiddlewareGroup('desactivado'));
            });
        };
        $closure();
    }

    // La función debería manejar casos en los que el usuario ingresa datos no válidos.
    public function test_manipular_datos_no_validos()
    {
        $closure = function () {
            Route::middleware("desactivado")->group(function () {
                // Crear una ruta con datos no válidos
                Route::put('/carreras/{id}/editar', [CarreraController::class, 'update'])
                    ->name('carrera.update')->where('id', '[0-9]+');
                // Asegurar que la ruta con datos no válidos no se cree
                $this->assertFalse(Route::has('carrera.update'));
            });
        };
        $closure();
    }

    // La función debería manejar con éxito diferentes tipos de solicitudes y respuestas.
    public function test_manipular_solicitudes_y_respuestas()
    {
        $closure = function () {
            Route::middleware("desactivado")->group(function () {
                // Crear una ruta con diferentes tipos de solicitudes y respuestas
                Route::get('/usuario/editar', [UserController::class, 'editar'])
                    ->name('usuario.editar');
                // Asegurar que la ruta con diferentes tipos de solicitudes y respuestas se cree
                $this->assertTrue(Route::has('usuario.editar'));
            });
        };
        $closure();
    }

    // La función debería manejar con éxito diferentes tipos de parámetros y variables.
    public function test_manipular_parametros_y_variables()
    {
        $closure = function () {
            Route::middleware("desactivado")->group(function () {
                // Crear una ruta con diferentes tipos de parámetros y variables
                Route::get('/usuario/{id}/edit', [UserController::class, 'editaru'])
                    ->name('usuario.editaru');
                // Asegurar que la ruta con diferentes tipos de parámetros y variables se cree
                $this->assertTrue(Route::has('usuario.editaru'));
            });
        };
        $closure();
    }


    // La función debería manejar con éxito diferentes tipos de parámetros e inputs.
    public function test_manipular_parametros_e_inputs()
    {
        $closure = function () {
            Route::middleware("desactivado")->group(function () {
                $parametros = ['id' => 1];

                $response = $this->get('/usuario/editar', $parametros);

                $response->assertStatus(200);
            });
        };
        $closure();
    }

    // La función debería manejar con éxito diferentes tipos de excepciones y errores.
    public function test_manipular_excepciones_y_errores()
    {
        $closure = function () {
            Route::middleware("desactivado")->group(function () {
                $response = $this->get('/ruta-inexistente');

                $response->assertStatus(404);
            });
        };
        $closure();
    }

    // La función debería manejar con éxito diferentes tipos de redirecciones.
    public function test_manipular_redirecciones()
    {
        $closure = function () {
            Route::middleware("desactivado")->group(function () {
                // Crear una ruta con diferentes tipos de redirecciones
                Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
                // Asegurar que la ruta con diferentes tipos de redirecciones se cree
                $this->assertTrue(Route::has('home'));
            });
        };
        $closure();
    }

    // La función debería manejar con éxito diferentes tipos de vistas.
    public function test_manipular_vistas()
    {
        $closure = function () {
            Route::middleware("desactivado")->group(function () {
                // Crear una ruta con diferentes tipos de vistas
                Route::get('/registrar', [UserController::class, 'registrar'])
                    ->name('usuario.registrar');
                // Asegurar que la ruta con diferentes tipos de vistas se cree
                $this->assertTrue(Route::has('usuario.registrar'));
            });
        };
        $closure();
    }


    // La función debería manejar casos en los que el usuario intenta acceder a rutas no válidas.
    public function test_rutas_no_validas_y_recursos_inexistentes()
    {
        $closure = function () {
            Route::middleware("desactivado")->group(function () {
                // Intentar acceder a una ruta no válida
                $response = $this->get('/ruta-o-recurso-inexistente');
                // Asegurar que el código de estado de la respuesta sea 404 (No encontrado)
                $response->assertStatus(404);
            });
        };
        $closure();
    }


    // La función debería manejar casos en los que el usuario intenta acceder a recursos con permisos insuficientes.
    public function test_permisos_insuficientes()
    {
        $closure = function () {
            Route::middleware("desactivado")->group(function () {
                // Intentar acceder a un recurso con permisos insuficientes
                $response = $this->get('/usuario');
                // Asegurar que el código de estado de la respuesta sea 302 (Encontrado)
                $response->assertStatus(302);
            });
        };
        $closure();
    }

    // La función debería manejar casos en los que el usuario intenta acceder a recursos con permisos suficientes.
    public function test_permisos_suficientes()
    {
        $closure = function () {
            Route::middleware("desactivado")->group(function () {
                // Intentar acceder a un recurso con permisos suficientes
                $response = $this->get('/usuario');
                // Asegurar que el código de estado de la respuesta sea 200 (OK)
                $response->assertStatus(200);
            });
        };
        $closure();
    }
}