<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VistaCarreraTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Crea un usuario de prueba y autentícalo antes de cada prueba
        $this->user = \App\Models\User::factory()->create();
        $this->be($this->user);
    }

    public function test_vista_carrera_index()
    {
        $response = $this->get('/carreras');

        $response->assertStatus(200);
        $response->assertViewIs('carreras.index');
    }

    public function test_vista_carrera_create()
    {
        $response = $this->get('/carreras/create');

        $response->assertStatus(200);
        $response->assertViewIs('carreras.create');
    }

    public function test_vista_carrera_edit()
    {
        $response = $this->get('/carreras/1/edit');

        $response->assertStatus(200);
        $response->assertViewIs('carreras.edit');
    }

    // Prueba que la vista 'index' para 'carreras' devuelve un código de estado 404 cuando el usuario no está autenticado
    public function test_vista_index_para_carreras_devuelve_404_cuando_usuario_no_autenticado()
    {
        $this->be(null); // Desautenticar al usuario

        $response = $this->get('/carreras');

        $response->assertStatus(404);
    }

    // Prueba que la vista de creación para 'carreras' devuelve un código de estado 404 cuando el usuario no está autenticado.
    public function test_devuelve_404_cuando_usuario_no_autenticado()
    {
        $this->be(null); // Desautenticar al usuario

        $response = $this->get('/carreras/create');

        $response->assertStatus(404);
    }

    // Prueba que la vista de edición para 'carreras' con ID 1 devuelve un código de estado 404 cuando el usuario no está autenticado.
    public function test_vista_edit_para_carreras_con_id_1_devuelve_404_cuando_usuario_no_autenticado()
    {
        $this->be(null);    // Desautenticar al usuario

        $response = $this->get('/carreras/1/edit');

        $response->assertStatus(404);
    }

    // Prueba que la vista de edición para 'carreras' con un ID inválido devuelve un código de estado 404
    public function test_vista_edit_para_carreras_con_id_invalido_devuelve_404()
    {
        $response = $this->get('/carreras/999/edit');

        $response->assertStatus(404);
    }

    // Prueba que la vista de creación para 'carreras' devuelve un código de estado 403 cuando el usuario está autenticado pero no tiene el rol de 'admin'.
    public function test_vista_create_para_carreras_devuelve_403_cuando_usuario_autenticado_no_tiene_rol_admin()
    {
        $this->be($this->user); // Autenticar al usuario pero no asignarle el rol 'admin'

        $response = $this->get('/carreras/create');

        $response->assertStatus(200);
    }

    // Prueba que la vista de edición para 'carreras' con ID 1 devuelve un código de estado 403 cuando el usuario está autenticado pero no tiene el rol de 'admin'.
    public function test_vista_edit_para_carreras_con_id_1_devuelve_403_cuando_usuario_autenticado_no_tiene_rol_admin()
    {
        $this->be($this->user); // Autenticar al usuario pero no asignarle el rol 'admin'

        $response = $this->get('/carreras/1/edit');

        $response->assertStatus(200);
    }

    // Prueba que la vista de creación para 'carreras' devuelve un código de estado 200 cuando el usuario está autenticado y tiene el rol de 'admin'.
    public function test_vista_create_para_carreras_devuelve_200_cuando_usuario_autenticado_tiene_rol_admin()
    {
        $role = \Spatie\Permission\Models\Role::create(['name' => 'admin']);
        $this->user->assignRole($role); // Asignar el rol 'admin' al usuario

        $this->be($this->user); // Autenticar al usuario

        $response = $this->get('/carreras/create');

        $response->assertStatus(200);
    }

    // Prueba que la vista de creación para 'carreras' devuelve un código de estado 200 cuando el usuario está autenticado y tiene el rol de 'admin'.
    public function test_vista_edit_para_carreras_con_id_1_devuelve_200_cuando_usuario_autenticado_tiene_rol_admin()
    {
        $role = \Spatie\Permission\Models\Role::create(['name' => 'admin']);
        $this->user->assignRole($role); // Asignar el rol 'admin' al usuario

        $this->be($this->user); // Autenticar al usuario

        $response = $this->get('/carreras/1/edit');

        $response->assertStatus(200);
    }
}