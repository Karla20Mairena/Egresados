<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserGuardarTest extends TestCase
{
    protected $user;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Buscar el usuario en la base de datos por correo electrónico
        $this->user = User::where('correo', 'cosme2@gmail.com')->first();

        // Si no puedes encontrar el usuario, podrías querer lanzar un error para que sepas que algo está mal
        if (!$this->user) {
            $this->fail('Usuario no encontrado');
        }

        // Actuar como el usuario encontrado
        $this->actingAs($this->user);
    }

    public function test_name_no_puede_estar_vacio()
    {
        $userData = [
            'username' => 'NombreDeUsuarioValido',
            'name' => '',
            'correo' => 'usuariovalido@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_name_no_puede_contener_numeros()
    {
        $userData = [
            'username' => 'NombreDeUsuarioValido',
            'name' => 'Nombre123',
            'correo' => 'usuariovalido@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_name_no_puede_contener_caracteres_especiales()
    {
        $userData = [
            'username' => 'NombreDeUsuarioValido',
            'name' => 'Nombre@',
            'correo' => 'usuariovalido@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_name_no_puede_tener_mas_de_50_caracteres()
    {
        $userData = [
            'username' => 'NombreDeUsuarioValido',
            'name' => str_repeat('a', 51),
            'correo' => 'usuariovalido@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_name_debe_tener_al_menos_2_caracteres()
    {
        $userData = [
            'username' => 'NombreDeUsuarioValido',
            'name' => 'a',
            'correo' => 'usuariovalido@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_name_puede_contener_espacios()
    {
        $userData = [
            'username' => 'NombreDeUsuarioValido',
            'name' => 'Nombre Compuesto',
            'correo' => 'usuariovalido@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionDoesNotHaveErrors(['name']);
    }

    public function test_name_puede_contener_guiones()
    {
        $userData = [
            'username' => 'NombreDeUsuarioValido',
            'name' => 'Apellido-Compuesto',
            'correo' => 'usuariovalido@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionDoesNotHaveErrors(['name']);
    }

    public function test_name_no_puede_contener_solo_espacios()
    {
        $userData = [
            'username' => 'NombreDeUsuarioValido',
            'name' => '   ',
            'correo' => 'usuariovalido@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_name_no_puede_comenzar_ni_terminar_con_espacios()
    {
        $userData = [
            'username' => 'NombreDeUsuarioValido',
            'name' => ' Nombre ',
            'correo' => 'usuariovalido@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_name_no_puede_tener_dos_espacios_seguidos()
    {
        $userData = [
            'username' => 'NombreDeUsuarioValido',
            'name' => 'Nombre  Compuesto',
            'correo' => 'usuariovalido@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_name_no_puede_contener_solo_numeros()
    {
        $userData = [
            'username' => 'NombreDeUsuarioValido',
            'name' => '12345',
            'correo' => 'usuariovalido@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_name_puede_contener_letras_acentuadas()
    {
        $userData = [
            'username' => 'NombreDeUsuarioValido',
            'name' => 'NombreÁcentuado',
            'correo' => 'usuariovalido@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionDoesNotHaveErrors(['name']);
    }

    public function test_name_no_puede_contener_emojis()
    {
        $userData = [
            'username' => 'NombreDeUsuarioValido',
            'name' => 'Nombre😀',
            'correo' => 'usuariovalido@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_username_no_puede_estar_vacio()
    {
        $userData = [
            'username' => '',
            'name' => 'NombreValido',
            'correo' => 'usuariovalido@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['username']);
    }

    public function test_username_debe_tener_al_menos_3_caracteres()
    {
        $userData = [
            'username' => 'ab',
            'name' => 'NombreValido',
            'correo' => 'usuariovalido@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['username']);
    }

    public function test_username_no_puede_tener_mas_de_20_caracteres()
    {
        $userData = [
            'username' => 'NombreDeUsuarioMuyLargoParaSerValido',
            'name' => 'NombreValido',
            'correo' => 'usuariovalido@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['username']);
    }

    public function test_username_no_puede_contener_espacios()
    {
        $userData = [
            'username' => 'Nombre DeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuariovalido@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['username']);
    }

    public function test_username_puede_contener_numeros_y_letras_pero_no_caracteres_especiales()
    {
        $userData = [
            'username' => 'NombreDeUsuario@',
            'name' => 'NombreValido',
            'correo' => 'usuariovalido@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['username']);
    }

    public function test_username_debe_ser_unico()
    {
        $userData = [
            'username' => 'NombreDeUsuarioExistente',
            'name' => 'NombreValido',
            'correo' => 'usuariovalido@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $this->post('/usuario/guardar', $userData);

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['username']);
    }

    public function test_username_puede_contener_guiones_bajos()
    {
        $userData = [
            'username' => 'Nombre_De_Usuario',
            'name' => 'NombreValido',
            'correo' => 'usuariovalido@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionDoesNotHaveErrors(['username']);
    }

    public function test_username_no_puede_contener_guiones_altos()
    {
        $userData = [
            'username' => 'Nombre-De-Usuario',
            'name' => 'NombreValido',
            'correo' => 'usuariovalido@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['username']);
    }

    public function test_username_no_puede_comenzar_con_un_numero()
    {
        $userData = [
            'username' => '1NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuariovalido@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['username']);
    }

    public function test_username_puede_contener_letras_mayusculas_y_minusculas()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuariovalido@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionDoesNotHaveErrors(['username']);
    }

    public function test_username_no_puede_contener_solo_numeros()
    {
        $userData = [
            'username' => '123456',
            'name' => 'NombreValido',
            'correo' => 'usuariovalido@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['username']);
    }

    public function test_username_no_puede_contener_caracteres_de_puntuacion()
    {
        $userData = [
            'username' => 'Nombre.De.Usuario',
            'name' => 'NombreValido',
            'correo' => 'usuariovalido@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['username']);
    }

    public function test_username_no_puede_contener_caracteres_acentuados()
    {
        $userData = [
            'username' => 'NómbreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuariovalido@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['username']);
    }

    public function test_correo_no_puede_estar_vacio()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => '',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['correo']);
    }

    public function test_correo_debe_ser_una_direccion_de_correo_electronico_valida()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'correoInvalido',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['correo']);
    }

    public function test_correo_debe_ser_unico()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuariovalido@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $this->post('/usuario/guardar', $userData);

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['correo']);
    }

    public function test_correo_no_puede_contener_espacios()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario valido@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['correo']);
    }

    public function test_correo_debe_contener_un_dominio_valido()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuariovalido@test',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['correo']);
    }

    public function test_correo_no_puede_contener_caracteres_especiales_antes_del_arroba()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario$valido@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['correo']);
    }

    public function test_correo_debe_contener_un_arroba()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuariovalidotest.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['correo']);
    }

    public function test_correo_no_puede_contener_mas_de_un_arroba()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@valido@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['correo']);
    }

    public function test_correo_debe_contener_al_menos_un_punto_despues_del_arroba()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['correo']);
    }

    public function test_correo_no_puede_contener_caracteres_especiales_despues_del_arroba()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@valido$test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['correo']);
    }

    public function test_correo_debe_contener_al_menos_un_caracter_antes_del_arroba()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => '@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['correo']);
    }

    public function test_correo_no_puede_contener_espacios_despues_del_arroba()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@ test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['correo']);
    }

    public function test_correo_no_puede_contener_espacios_antes_del_arroba()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario @test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['correo']);
    }

    public function test_correo_debe_contener_al_menos_un_caracter_despues_del_arroba()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['correo']);
    }

    public function test_correo_no_puede_comenzar_con_un_punto()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => '.usuario@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['correo']);
    }

    public function test_correo_no_puede_terminar_con_un_punto()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@test.com.',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['correo']);
    }

    public function test_correo_no_puede_contener_dos_puntos_consecutivos()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@test..com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['correo']);
    }

    public function test_correo_no_puede_contener_un_punto_inmediatamente_despues_del_arroba()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@.test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['correo']);
    }

    public function test_correo_no_puede_contener_un_punto_inmediatamente_antes_del_arroba()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario.@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['correo']);
    }

    public function test_correo_no_puede_contener_arroba_en_el_dominio()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@test@com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['correo']);
    }

    public function test_correo_debe_contener_al_menos_dos_caracteres_despues_del_ultimo_punto()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@test.c',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['correo']);
    }

    public function test_correo_no_puede_contener_caracteres_especiales_al_inicio_o_al_final_del_nombre_de_usuario()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => '.usuario.@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['correo']);
    }

    public function test_nacimiento_no_puede_estar_vacio()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@test.com',
            'nacimiento' => '',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['nacimiento']);
    }

    public function test_nacimiento_debe_ser_una_fecha_valida()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@test.com',
            'nacimiento' => 'fecha-no-valida',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['nacimiento']);
    }

    public function test_nacimiento_no_puede_ser_una_fecha_en_el_futuro()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@test.com',
            'nacimiento' => date('Y-m-d', strtotime('+1 day')),
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['nacimiento']);
    }

    public function test_nacimiento_no_puede_ser_una_fecha_antes_del_ano_1900()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@test.com',
            'nacimiento' => '1899-12-31',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['nacimiento']);
    }

    public function test_nacimiento_no_puede_ser_una_fecha_que_no_exista()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@test.com',
            'nacimiento' => '2022-02-30',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['nacimiento']);
    }

    public function test_nacimiento_debe_estar_en_el_formato_correcto()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@test.com',
            'nacimiento' => '01-01-2000',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['nacimiento']);
    }

    public function test_nacimiento_no_puede_ser_una_fecha_con_el_ano_actual()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@test.com',
            'nacimiento' => date('Y-m-d'),
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['nacimiento']);
    }

    public function test_nacimiento_no_puede_ser_una_fecha_con_un_formato_invalido()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@test.com',
            'nacimiento' => '31-12-2000',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['nacimiento']);
    }

    public function test_nacimiento_no_puede_ser_una_fecha_con_un_mes_invalido()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@test.com',
            'nacimiento' => '2000-13-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['nacimiento']);
    }

    public function test_nacimiento_no_puede_ser_una_fecha_con_un_dia_invalido()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@test.com',
            'nacimiento' => '2000-01-32',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['nacimiento']);
    }

    public function test_nacimiento_no_puede_ser_una_fecha_con_un_ano_invalido()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@test.com',
            'nacimiento' => '0000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['nacimiento']);
    }

    public function test_nacimiento_no_puede_ser_una_fecha_con_caracteres_no_numericos()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@test.com',
            'nacimiento' => '2000-01-0a',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['nacimiento']);
    }

    public function test_nacimiento_no_puede_ser_una_cadena_de_texto_aleatoria()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@test.com',
            'nacimiento' => 'cadena-aleatoria',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['nacimiento']);
    }

    public function test_identidad_no_puede_estar_vacio()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['identidad']);
    }

    public function test_identidad_debe_ser_una_cadena_de_texto()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => 1234567890,
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['identidad']);
    }

    public function test_identidad_no_puede_contener_caracteres_especiales()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345@',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['identidad']);
    }

    public function test_identidad_debe_tener_un_formato_especifico()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234123412345', // Sin guiones
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['identidad']);
    }

    public function test_identidad_no_puede_ser_una_cadena_de_texto_aleatoria()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => 'cadena-aleatoria',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['identidad']);
    }

    public function test_identidad_no_puede_ser_un_numero_flotante()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => 123.456,
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['identidad']);
    }

    public function test_identidad_no_puede_tener_mas_de_un_certo_numero_de_caracteres()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345-12345', // Más de 15 caracteres
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['identidad']);
    }

    public function test_identidad_no_puede_ser_un_numero_de_identidad_ya_existente_en_la_base_de_datos()
    {
        // Primero, crea un usuario con una identidad específica
        $existingUser = User::factory()->create([
            'identidad' => '1234-1234-12345',
        ]);

        // Luego, intenta crear un nuevo usuario con la misma identidad
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['identidad']);
    }

    public function test_identidad_no_puede_tener_guiones_consecutivos()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234--1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['identidad']);
    }

    public function test_identidad_no_puede_comenzar_o_terminar_con_guion()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '-1234-1234-12345',
            'telefono' => '1234-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['identidad']);

        $userData['identidad'] = '1234-1234-12345-';

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['identidad']);
    }

    public function test_telefono_no_puede_estar_vacio()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['telefono']);
    }

    public function test_telefono_debe_tener_formato_especifico()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '12341234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['telefono']);
    }

    public function test_telefono_no_puede_contener_letras()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-ABCD',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['telefono']);
    }

    public function test_telefono_no_puede_contener_espacios()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234 1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['telefono']);
    }

    public function test_telefono_no_puede_tener_mas_o_menos_de_4_digitos_antes_del_guion()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '123-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['telefono']);

        $userData['telefono'] = '12345-1234';

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['telefono']);
    }

    public function test_telefono_no_puede_tener_mas_de_9_caracteres()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '12345-12345',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['telefono']);
    }

    public function test_telefono_no_puede_tener_menos_de_9_caracteres()
    {
        $userData = [
            'username' => 'NombreDeUsuario',
            'name' => 'NombreValido',
            'correo' => 'usuario@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '123-1234',
            'rol' => 'RolValido',
        ];

        $response = $this->post('/usuario/guardar', $userData);

        $response->assertSessionHasErrors(['telefono']);
    }
}
