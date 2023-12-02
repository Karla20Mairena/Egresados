<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VistaEgresadoTest extends TestCase
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

    public function test_VistaEgresadoIndex()
    {
        $response = $this->get('/egresado');

        $response->assertStatus(200);
        $response->assertViewIs('egresado.index');
    }

    public function test_VistaEgresadoCreate()
    {
        $response = $this->get('/egresado/create');

        $response->assertStatus(200);
        $response->assertViewIs('egresado.create');
    }

    public function test_VistaEgresadoEdit()
    {
        $response = $this->get('/egresado/1/edit');

        $response->assertStatus(200);
        $response->assertViewIs('egresado.edit');
    }

    //Prueba de la vista index para egresados devuelve un código de estado 404 cuando el usuario no está autenticado
    public function test_VistaIndexEgresadoCuandoUsuarioNoAutenticado()
    {
        $this->be(null); // Desautenticar al usuario

        $response = $this->get('/egresado');

        $response->assertStatus(404);
    }

    
    //Prueba de la vista create para egresados devuelve un código de estado 404 cuando el usuario no está autenticado
    public function test_VistaCreateEgresadoCuandoUsuarioNoAutenticado()
    {
        $this->be(null); // Desautenticar al usuario

        $response = $this->get('/egresado/create');

        $response->assertStatus(404);
    }

     //Prueba de la vista edit para egresados devuelve un código de estado 404 cuando el usuario no está autenticado
     public function test_VistaEditEgresadoCuandoUsuarioNoAutenticado()
     {
         $this->be(null); // Desautenticar al usuario
 
         $response = $this->get('/egresado/1/edit');
 
         $response->assertStatus(404);
     }


    // Prueba de la vista de edit para egresados con un ID inválido devuelve un código de estado 404
    public function test_VistaEditEgresadosConIDInvalido()
    {
        $response = $this->get('/egresado/999/edit');

        $response->assertStatus(404);
    }

    // Prueba de la vista edit para egresados devuelve un código de estado 403 cuando el usuario está autenticado pero no tiene el rol de 'admin'.
    public function test_VistaEditPropietarioSinRolAdmin()
    { 
    $this->user->assignRole('admin'); // Asignar el rol 'admin' al usuario

    $this->be($this->user); // Autenticar al usuario

    // Simular la eliminación del rol 'admin'
    $this->user->removeRole('admin');

    $response = $this->get('/propietario/1/editar');

    $response->assertStatus(403); // Verificar que se recibe un status 403 (Forbidden)
    }

     // Prueba de la vista create para egresados devuelve un código de estado 403 cuando el usuario está autenticado pero no tiene el rol de 'admin'.
     public function test_VistaCreatePropietarioSinRolAdmin()
     { 
     $this->user->assignRole('admin'); // Asignar el rol 'admin' al usuario
 
     $this->be($this->user); // Autenticar al usuario
 
     // Simular la eliminación del rol 'admin'
     $this->user->removeRole('admin');
 
     $response = $this->get('/propietario/create');

     $response->assertStatus(403); // Verificar que se recibe un status 403 (Forbidden)
     }
 


    // Prueba de la vista edit para egresados con ID 1 devuelve un código de estado 403 cuando el usuario está autenticado pero no tiene el rol de 'admin'.
    public function test__VistaEditEgresadoUsuarioAutenticado_ID_1_NoTieneRolAdmin()
    {
        $this->be($this->user); // Autenticar al usuario sin asignar rol 'admin'

        $response = $this->get('/egresado/1/edit');

        $response->assertStatus(403);
    }
    
      // Prueba de la vista index para egresados devuelve un código de estado 200 cuando el usuario está autenticado y tiene el rol de 'admin'.
      public function test_VistaIndexEgresadoCuandoUsuarioAutenticadoRolAdmin()
      {
        //   $role = \Spatie\Permission\Models\Role::create(['name' => 'admin']);
          $this->user->assignRole(); // Asignar el rol 'admin' al usuario
  
          $this->be($this->user); // Autenticar al usuario
  
          $response = $this->get('/egresado');
  
          $response->assertStatus(200);
      }

    // Prueba de la vista create para egresados devuelve un código de estado 200 cuando el usuario está autenticado y tiene el rol de 'admin'.
    public function test_VistaCreateEgresadoCuandoUsuarioAutenticadoRolAdmin()
    {
        // $role = \Spatie\Permission\Models\Role::create(['name' => 'admin']);
        $this->user->assignRole(); // Asignar el rol 'admin' al usuario

        $this->be($this->user); // Autenticar al usuario

        $response = $this->get('/egresado/create');

        $response->assertStatus(200);
    }

    
    // Prueba de la vista edit para egresados devuelve un código de estado 200 cuando el usuario está autenticado y tiene el rol de 'admin'.
    public function test_VistaEditEgresadoCuandoUsuarioAutenticadoRolAdmin()
    {
        // $role = \Spatie\Permission\Models\Role::create(['name' => 'admin']);
        $this->user->assignRole(); // Asignar el rol 'admin' al usuario

        $this->be($this->user); // Autenticar al usuario

        $response = $this->get('/egresado/1/edit');

        $response->assertStatus(200);
    }
}