<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VistaAyudaTest extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Crea un usuario de prueba y autentícalo antes de cada prueba
        $this->user = \App\Models\User::factory()->create();
        $this->be($this->user);
    }

    public function test_vista_ayuda()
    {
        $response = $this->get('/ayudaindex');

        $response->assertStatus(200);
        $response->assertViewIs('ayuda.ayudaindex');
    }

    public function test_vista_ayuda_egresados()
    {
        $response = $this->get('/infoegresados');

        $response->assertStatus(200);
        $response->assertViewIs('ayuda.infoegresados');
    }

    public function test_vista_ayuda_carreras()
    {
        $response = $this->get('/infocarreras');

        $response->assertStatus(200);
        $response->assertViewIs('ayuda.infocarreras');
    }

    public function test_vista_ayuda_usuario()
    {
        $response = $this->get('/infousuario');

        $response->assertStatus(200);
        $response->assertViewIs('ayuda.infousuario');
    }

    public function test_vista_ayuda_perfil()
    {
        $response = $this->get('/infoperfil');

        $response->assertStatus(200);
        $response->assertViewIs('ayuda.infoperfil');
    }

    public function test_vista_ayuda_grafico()
    {
        $response = $this->get('/infografico');

        $response->assertStatus(200);
        $response->assertViewIs('ayuda.infografico');
    }

    // devuelve un código de estado 404 cuando el usuario no está autenticado
    public function test_vista_ayuda_devuelve_404_cuando_usuario_no_autenticado()
    {
        $this->be(null); // Desautenticar al usuario

        $response = $this->get('/ayudaindex');

        $response->assertStatus(404);
    }

    public function test_vista_ayuda_egresados_devuelve_404_cuando_usuario_no_autenticado()
    {
        $this->be(null); // Desautenticar al usuario

        $response = $this->get('/infoegresados');

        $response->assertStatus(404);
    }

    public function test_vista_ayuda_carreras_devuelve_404_cuando_usuario_no_autenticado()
    {
        $this->be(null); // Desautenticar al usuario

        $response = $this->get('/infocarreras');

        $response->assertStatus(404);
    }

    public function test_vista_ayuda_usuario_devuelve_404_cuando_usuario_no_autenticado()
    {
        $this->be(null); // Desautenticar al usuario

        $response = $this->get('/infousuario');

        $response->assertStatus(404);
    }

    public function test_vista_ayuda_perfil_devuelve_404_cuando_usuario_no_autenticado()
    {
        $this->be(null); // Desautenticar al usuario

        $response = $this->get('/infoperfil');

        $response->assertStatus(404);
    }

    public function test_vista_ayuda_grafico_devuelve_404_cuando_usuario_no_autenticado()
    {
        $this->be(null); // Desautenticar al usuario

        $response = $this->get('/infografico');

        $response->assertStatus(404);
    }

    // Con un valores invalidos
    public function test_vista_ayuda_con_valor_invalido_devuelve_404()
    {
        $response = $this->get('/ayudaindex/1');

        $response->assertStatus(404);
    }

    public function test_vista_ayuda_egresados_con_valor_invalido_devuelve_404()
    {
        $response = $this->get('/infoegresados/1');

        $response->assertStatus(404);
    }

    public function test_vista_ayuda_carreras_con_valor_invalido_devuelve_404()
    {
        $response = $this->get('/infocarreras/1');

        $response->assertStatus(404);
    }

    public function test_vista_ayuda_usuario_con_valor_invalido_devuelve_404()
    {
        $response = $this->get('/infousuario/1');

        $response->assertStatus(404);
    }

    public function test_vista_ayuda_perfil_con_valor_invalido_devuelve_404()
    {
        $response = $this->get('/infoperfil/1');

        $response->assertStatus(404);
    }

    public function test_vista_ayuda_grafico_con_valor_invalido_devuelve_404()
    {
        $response = $this->get('/infografico/1');

        $response->assertStatus(404);
    }

    public function test_vista_ayuda_con_valor_invalido_devuelve_404_cuando_usuario_no_autenticado()
    {
        $this->be(null); // Desautenticar al usuario

        $response = $this->get('/ayudaindex/1');

        $response->assertStatus(404);
    }

    public function test_vista_ayuda_egresados_con_valor_invalido_devuelve_404_cuando_usuario_no_autenticado()
    {
        $this->be(null); // Desautenticar al usuario

        $response = $this->get('/infoegresados/1');

        $response->assertStatus(404);
    }

    public function test_vista_ayuda_carreras_con_valor_invalido_devuelve_404_cuando_usuario_no_autenticado()
    {
        $this->be(null); // Desautenticar al usuario

        $response = $this->get('/infocarreras/1');

        $response->assertStatus(404);
    }

    public function test_vista_ayuda_usuario_con_valor_invalido_devuelve_404_cuando_usuario_no_autenticado()
    {
        $this->be(null); // Desautenticar al usuario

        $response = $this->get('/infousuario/1');

        $response->assertStatus(404);
    }

    public function test_vista_ayuda_perfil_con_valor_invalido_devuelve_404_cuando_usuario_no_autenticado()
    {
        $this->be(null); // Desautenticar al usuario

        $response = $this->get('/infoperfil/1');

        $response->assertStatus(404);
    }

    public function test_vista_ayuda_grafico_con_valor_invalido_devuelve_404_cuando_usuario_no_autenticado()
    {
        $this->be(null); // Desautenticar al usuario

        $response = $this->get('/infografico/1');

        $response->assertStatus(404);
    }
}