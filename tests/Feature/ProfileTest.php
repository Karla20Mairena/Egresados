<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\User;

class ProfileControllerTest extends TestCase
{

    public function testUpdateProfile()
    {
        // Uuario de prueba
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // Solicitud de actualización de perfil
        $response = $this->put('/profile/update', [
            'name' => 'Nuevo Nombre',
            'email' => 'nuevoemail@example.com',
        ]);

        // Verifica que la respuesta sea exitosa
        $response->assertStatus(302);

        // Verifica que el perfil se haya actualizado en la base de datos
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Nuevo Nombre',
            'email' => 'nuevoemail@example.com',
        ]);
    }

    public function testChangePassword()
    {
        // Crea un usuario de prueba y autentica
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // Simula una solicitud para cambiar la contraseña
        $response = $this->put('/profile/password', [
            'password' => 'nuevacontraseña',
            'password_confirmation' => 'nuevacontraseña',
        ]);

        // Verifica que la respuesta sea exitosa
        $response->assertStatus(302);

        // Verifica que la contraseña se haya actualizado en la base de datos
        $this->assertCredentials([
            'email' => $user->email,
            'password' => 'nuevacontraseña',
        ]);
    }
}

