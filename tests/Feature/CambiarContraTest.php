<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CambiarContraTest extends TestCase
{

    //Esta es una prueba que verifica si la página que contiene el formulario de cambiar contraseña está disponible y devuelve un 
    //código de estado HTTP 200.
    public function testCambiarContraFormIsAvailable()
    {
        $response = $this->get('/egresado/contrasenia');
        $response->assertStatus(200);
    }

    public function testChangePassword()
    {
        // Crea un usuario de prueba
        $user = factory(User::class)->create([
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
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ]);

        // Verifica que la contraseña se haya actualizado en la base de datos
        $this->assertTrue(Hash::check($newPassword, $user->password));

        // Verifica que se haya redirigido a la página anterior con el mensaje de éxito
        $response->assertRedirect()->assertSessionHas('passwordStatus', 'Password successfully updated.');

        // Cierra la sesión del usuario
        Auth::logout();
    }

    public function testChangePasswordNotAllowedForDefaultUser()
    {
        // Crea un usuario de prueba con ID 1 (default user)
        $user = factory(User::class)->create([
            'id' => 1,
        ]);

        // Iniciar sesión como el usuario
        Auth::login($user);

        // Datos de prueba para cambiar la contraseña
        $newPassword = 'nueva_contra123';

        $response = $this->post('contrasenia.cambiar', [
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ]);

        // Verifica que no se haya actualizado la contraseña en la base de datos
        $this->assertFalse(Hash::check($newPassword, $user->password));

        // Verifica que se haya redirigido de vuelta con un mensaje de error
        $response->assertRedirect()->assertSessionHasErrors('not_allow_password');

        // Cierra la sesión del usuario
        Auth::logout();
    }
}
