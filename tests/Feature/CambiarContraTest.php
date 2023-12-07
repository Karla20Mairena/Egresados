<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CambiarContraTest extends TestCase
{

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->actingAs($this->user);
    }

    public function testChangePassword()
    {
        // Crea un usuario de prueba
        //se modifico la estructura de la factory para poder trabajar con laravel 8
        $user = User::factory()->create([
            'id' => 2,
        ]);
        
        // Iniciar sesión como el usuario
        Auth::login($user);

        // Datos de prueba para cambiar la contraseña
        $newPassword = 'nueva_contra123';

        
        $response = $this->post('contrasenia', [
            'viejapassword' => 'password', // Contraseña actual
            'password' => $newPassword, // Nueva contraseña
            'password_confirmation' => $newPassword // Confirmación de la nueva contraseña
        ]);

        //refrescamos los datos para efectuar los cambios
        $user->refresh();
        // Verifica que la contraseña se haya actualizado en la base de datos
        $this->assertTrue(Hash::check($newPassword, $user->password));

        // Verifica que se haya redirigido a la página anterior con el mensaje de éxito
        //el mensaje de error y la variable era incorrecto
        $response->assertRedirect()->assertSessionHas('mensaje', 'La contraseña fue actualizada exitosamente.');

        // Cierra la sesión del usuario
        Auth::logout();
    }

    public function testChangePasswordNotAllowedForDefaultUser()
    {
        // Crea un usuario de prueba con ID 1 (default user)
        $user = User::factory()->create([
            'id' => 1,
        ]);

        // Iniciar sesión como el usuario
        Auth::login($user);

        // Datos de prueba para cambiar la contraseña
        $newPassword = 'nueva_contra123';

      
        $response = $this->post('contrasenia', [
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ]);

        // Verifica que no se haya actualizado la contraseña en la base de datos
        $this->assertFalse(Hash::check($newPassword, $user->password));

        // Verifica que se haya redirigido de vuelta con un mensaje de error
        //el mensaje de error y la variable era incorrecto
        $response->assertRedirect()->assertSessionHasErrors();

        // Cierra la sesión del usuario
        Auth::logout();
    }
}