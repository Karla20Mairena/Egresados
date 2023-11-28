<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class ProfileControllerTest extends TestCase
{

       //refrescamos base de datos y logiamos
       use RefreshDatabase;
 
       protected function setUp(): void
       {
           parent::setUp();
   
           //migramos y sembramos
           $this->artisan('migrate:refresh');
           $this->artisan('db:seed');
       }

    public function testUpdateProfile()
    {
        $user = User::find(1);

        // Solicitud de actualización de perfil
        $response = $this->put('/profile/update', [
            'name' => 'Nuevo Nombre',
            'correo' => 'nuevocorreo@example.com',
        ]);

        // Verifica que la respuesta sea exitosa
        $response->assertStatus(302);

        // Verifica que el perfil se haya actualizado en la base de datos
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Nuevo Nombre',
            'correo' => 'nuevocorreo@example.com',
        ]);
    }

    public function testChangePassword()
    {
        $user = User::find(1);
        
        // Simula una solicitud para cambiar la contraseña
        $response = $this->put('/profile/password', [
            'password' => 'nuevacontraseña',
            'password_confirmation' => 'nuevacontraseña',
        ]);

        // Verifica que la respuesta sea exitosa
        $response->assertStatus(302);

        // Verifica que la contraseña se haya actualizado en la base de datos
        $this->assertCredentials([
            'correo' => $user->correo,
            'password' => 'nuevacontraseña',
        ]);
    }
}

