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
}