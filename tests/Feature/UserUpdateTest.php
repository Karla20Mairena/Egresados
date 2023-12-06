<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UserUpdateTest extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->actingAs($this->user);
    }
    public function test_formulario_editar_usuario_disponible()
    {
        $response = $this->get('/usuario/20/edit');
        $response->assertStatus(200);
    }

    public function test_actualizar_elemento_correctamente()
    {
        $userData = [
            'name' => 'Updated User',
            'username' => 'updatedusername',
            'correo' => 'updateduser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'password' => 'updatedpassword',
            'password_confirmation' => 'updatedpassword',
            'rol' => 'updatedRole',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertRedirect('/usuario/' . $this->user->id);

        $this->assertDatabaseHas('users', [
            'name' => 'Updated User',
            'username' => 'updatedusername',
            'correo' => 'updateduser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ]);

        $updatedUser = User::where('username', 'updatedusername')->first();
        $this->assertTrue($updatedUser->hasRole('updatedRole'));
    }

    public function test_actualizar_usuario_inexistente()
    {
        $userData = [
            'name' => 'Updated User',
            'username' => 'updatedusername',
            'correo' => 'updateduser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
            'password' => 'updatedpassword',
            'password_confirmation' => 'updatedpassword',
            'rol' => 'updatedRole',
        ];

        $response = $this->put('/usuario/actualizar/999', $userData);

        $response->assertStatus(404);
    }

    public function test_validacion_campos_vacios()
    {
        $userData = [
            'name' => '',
            'username' => '',
            'correo' => '',
            'nacimiento' => '',
            'identidad' => '',
            'telefono' => '',
            'password' => '',
            'password_confirmation' => '',
            'rol' => '',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors([
            'name',
            'username',
            'correo',
            'nacimiento',
            'identidad',
            'telefono',
            'password',
            'rol',
        ]);
    }

    public function test_name_campo_vacio()
    {
        $userData = [
            'name' => '',
            'username' => 'validusername',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_name_campo_demasiado_corto()
    {
        $userData = [
            'name' => 'A',
            'username' => 'validusername',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_name_campo_demasiado_largo()
    {
        $userData = [
            'name' => str_repeat('A', 256),
            'username' => 'validusername',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_name_campo_solo_espacios()
    {
        $userData = [
            'name' => '     ',
            'username' => 'validusername',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_name_campo_con_numeros()
    {
        $userData = [
            'name' => 'Name123',
            'username' => 'validusername',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_name_campo_caracteres_especiales()
    {
        $userData = [
            'name' => 'Name@#',
            'username' => 'validusername',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_name_campo_comienza_con_espacio()
    {
        $userData = [
            'name' => ' Name',
            'username' => 'validusername',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_name_campo_termina_con_espacio()
    {
        $userData = [
            'name' => 'Name ',
            'username' => 'validusername',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_name_campo_solo_numeros()
    {
        $userData = [
            'name' => '123456',
            'username' => 'validusername',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_username_campo_vacio()
    {
        $userData = [
            'username' => '',
            'name' => 'Valid Name',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['username']);
    }

    public function test_username_campo_solo_caracteres_especiales()
    {
        $userData = [
            'username' => '@#$%^&*',
            'name' => 'Valid Name',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['username']);
    }

    public function test_username_campo_con_espacios_en_medio()
    {
        $userData = [
            'username' => 'Username With Spaces',
            'name' => 'Valid Name',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['username']);
    }

    public function test_username_campo_con_caracteres_no_alfanumericos_al_final()
    {
        $userData = [
            'username' => 'Username123@',
            'name' => 'Valid Name',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['username']);
    }

    public function test_username_campo_demasiado_corto()
    {
        $userData = [
            'username' => 'Us',
            'name' => 'Valid Name',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['username']);
    }

    public function test_username_campo_demasiado_largo()
    {
        $userData = [
            'username' => str_repeat('A', 256),
            'name' => 'Valid Name',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['username']);
    }

    public function test_username_debe_ser_unico()
    {
        $existingUser = User::factory()->create(['username' => 'existingUsername']);

        $userData = [
            'username' => 'existingUsername',
            'name' => 'Valid Name',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['username']);
    }

    public function test_username_puede_contener_numeros_y_letras()
    {
        $userData = [
            'username' => 'Username123',
            'name' => 'Valid Name',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionDoesNotHaveErrors(['username']);
    }

    public function test_username_puede_contener_guiones_bajos_y_guiones()
    {
        $userData = [
            'username' => 'Username-123_',
            'name' => 'Valid Name',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionDoesNotHaveErrors(['username']);
    }

    public function test_correo_campo_no_puede_estar_vacio()
    {
        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => '',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['correo']);
    }

    public function test_correo_debe_ser_valido()
    {
        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => 'invalidEmail',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['correo']);
    }

    public function test_correo_debe_ser_unico()
    {
        $existingUser = User::factory()->create(['correo' => 'existingEmail@test.com']);

        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => 'existingEmail@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['correo']);
    }

    public function test_correo_no_puede_ser_demasiado_largo()
    {
        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => str_repeat('A', 256) . '@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['correo']);
    }

    public function test_correo_puede_contener_caracteres_especiales_permitidos()
    {
        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => 'valid-user.name+123@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionDoesNotHaveErrors(['correo']);
    }

    public function test_correo_puede_contener_caracteres_especiales_no_permitidos()
    {
        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => 'validuser@test#com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['correo']);
    }

    public function test_correo_debe_contener_dominio_valido()
    {
        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => 'validuser@invalidDomain',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['correo']);
    }

    public function test_correo_no_puede_contener_espacios()
    {
        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => 'valid user@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['correo']);
    }

    public function test_correo_debe_contener_arroba()
    {
        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => 'validuserwithoutat.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['correo']);
    }

    public function test_correo_no_puede_comenzar_ni_terminar_con_punto()
    {
        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => '.validuser.@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['correo']);
    }

    public function test_nacimiento_campo_no_puede_estar_vacio()
    {
        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => 'validuser@test.com',
            'nacimiento' => '',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['nacimiento']);
    }

    public function test_nacimiento_debe_ser_fecha_valida()
    {
        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => 'validuser@test.com',
            'nacimiento' => 'invalidDate',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['nacimiento']);
    }

    public function test_nacimiento_no_puede_ser_fecha_en_el_futuro()
    {
        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => 'validuser@test.com',
            'nacimiento' => date('Y-m-d', strtotime('+1 day')),
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['nacimiento']);
    }

    public function test_nacimiento_no_puede_ser_fecha_demasiado_antigua()
    {
        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => 'validuser@test.com',
            'nacimiento' => '1899-12-31',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['nacimiento']);
    }

    public function test_nacimiento_no_puede_ser_fecha_con_dia_no_numerico()
    {
        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-0A',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['nacimiento']);
    }

    public function test_nacimiento_no_puede_ser_fecha_con_mes_no_numerico()
    {
        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-0A-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['nacimiento']);
    }

    public function test_nacimiento_no_puede_ser_fecha_con_año_no_numerico()
    {
        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => 'validuser@test.com',
            'nacimiento' => '200A-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['nacimiento']);
    }

    public function test_identidad_no_puede_contener_espacios()
    {
        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234 -1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['identidad']);
    }

    public function test_identidad_no_puede_contener_letras()
    {
        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-123A-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['identidad']);
    }

    public function test_identidad_debe_tener_formato_especifico()
    {
        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234123412345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['identidad']);
    }

    public function test_identidad_campo_no_puede_estar_vacio()
    {
        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['identidad']);
    }

    public function test_identidad_no_puede_tener_mas_o_menos_de_4_digitos_entre_guiones()
    {
        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-123-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['identidad']);

        $userData['identidad'] = '1234-12345-12345';

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['identidad']);
    }

    public function test_identidad_no_puede_tener_mas_o_menos_de_5_digitos_despues_del_segundo_guion()
    {
        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-1234',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['identidad']);

        $userData['identidad'] = '1234-1234-123456';

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['identidad']);
    }

    public function test_identidad_no_puede_tener_menos_de_15_caracteres()
    {
        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-1234',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['identidad']);
    }

    public function test_identidad_no_puede_tener_mas_de_15_caracteres()
    {
        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '12345-12345-123456',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['identidad']);
    }

    public function test_identidad_no_puede_tener_mas_o_menos_de_4_digitos_antes_del_primer_guion()
    {
        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '123-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['identidad']);

        $userData['identidad'] = '12345-1234-12345';

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['identidad']);
    }

    public function test_identidad_no_puede_contener_caracteres_especiales()
    {
        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345#',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['identidad']);
    }

    public function test_identidad_no_puede_tener_guiones_consecutivos()
    {
        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234--1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['identidad']);
    }

    public function test_identidad_no_puede_comenzar_o_terminar_con_guion()
    {
        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '-1234-1234-12345',
            'telefono' => '1234-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['identidad']);

        $userData['identidad'] = '1234-1234-12345-';

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['identidad']);
    }

    public function test_telefono_no_puede_estar_vacio()
    {
        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['telefono']);
    }

    public function test_telefono_debe_tener_formato_especifico()
    {
        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '12341234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['telefono']);
    }

    public function test_telefono_no_puede_contener_letras()
    {
        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234-ABCD',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['telefono']);
    }

    public function test_telefono_no_puede_contener_espacios()
    {
        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '1234 1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['telefono']);
    }

    public function test_telefono_no_puede_tener_mas_o_menos_de_4_digitos_antes_del_guion()
    {
        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '123-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['telefono']);

        $userData['telefono'] = '12345-1234';

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['telefono']);
    }

    public function test_telefono_no_puede_tener_mas_de_9_caracteres()
    {
        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '12345-12345',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['telefono']);
    }

    public function test_telefono_no_puede_tener_menos_de_9_caracteres()
    {
        $userData = [
            'username' => 'ValidUsername',
            'name' => 'Valid Name',
            'correo' => 'validuser@test.com',
            'nacimiento' => '2000-01-01',
            'identidad' => '1234-1234-12345',
            'telefono' => '123-1234',
        ];

        $response = $this->put('/usuario/actualizar/' . $this->user->id, $userData);

        $response->assertSessionHasErrors(['telefono']);
    }
}
