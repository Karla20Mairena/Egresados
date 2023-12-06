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

    public function testChangePassword()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        // Crea un usuario de prueba
        //se modifico la estructura de la factory para poder trabajar con laravel 8
        $user = User::factory()->create([
            'name' => "Juan Pablo Perez",
            'correo' => "pablojuan@gmail.com",
            'nacimiento' => "08-10-01",
            'username' => "pablo",
            'password' => "pablo123",
            'identidad' => "0703200103082",
            'telefono' => "9856-2300",
            'estado' => 1,
        ]);
        
        // Iniciar sesión como el usuario
        Auth::login($user);

        // Datos de prueba para cambiar la contraseña
        $newPassword = 'nueva_contra123';

        
        $response = $this->post('contrasenia.cambiar', [
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
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        $this->withoutExceptionHandling();
        // Crea un usuario de prueba con ID 1 (default user)
        $user = User::factory()->create([
            'id' => 1,
        ]);

        // Iniciar sesión como el usuario
        Auth::login($user);

        // Datos de prueba para cambiar la contraseña
        $newPassword = 'nueva_contra123';

      
        $response = $this->post('/contrasenia', [
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ]);

        // Verifica que no se haya actualizado la contraseña en la base de datos
        $this->assertFalse(Hash::check($newPassword, $user->password));

        // Verifica que se haya redirigido de vuelta con un mensaje de error
        //el mensaje de error y la variable era incorrecto
        $response->assertRedirect()->assertSessionHasErrors('not_allow_password');

        // Cierra la sesión del usuario
        Auth::logout();
    }
}