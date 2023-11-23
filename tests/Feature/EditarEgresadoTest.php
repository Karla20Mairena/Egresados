<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditarEgresadoTest extends TestCase
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

    //Esta es una prueba que verifica si la página que contiene el formulario de editar egresados está disponible y devuelve un 
    //código de estado HTTP 200.
    public function testEditFormIsAvailable()
    {
        $response = $this->get('/egresado/edit');
        $response->assertStatus(200);
    }
}
