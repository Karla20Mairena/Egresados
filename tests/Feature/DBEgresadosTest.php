<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Carrera;
use App\Models\Egresado;

class DBEgresadosTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    //Todas las pruebas esten dirigidas a la integrdad de la base de datos, que este normalizada, y pruebas a las relaciones de las tablas

    public function test_restriccion_de_clave_unica()
    {
        $carrera = Carrera::create([
            'Carrera' => 'Ingeniería en Sistemas',
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        $carreraDuplicada = Carrera::create([
            'Carrera' => 'Ingeniería en Sistemas',
        ]);
    }

    public function test_restriccion_de_clave_foranea()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        $egresado = Egresado::create([
            'nombre' => 'Juan Perez',
            'año_egresado' => 2020,
            'fecha_nacimiento' => '1990-01-01',
            'identidad' => '12345678',
            'nro_expediente' => 1234,
            'gene_id' => 1,
            'carre_id' => 9999, // Este ID no existe en la tabla carreras
        ]);
    }

    public function test_existencia_de_datos_necesarios()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        $egresado = Egresado::create([
            'año_egresado' => 2020,
            'fecha_nacimiento' => '1990-01-01',
            'identidad' => '12345678',
            'nro_expediente' => 1234,
            'gene_id' => 1,
            'carre_id' => 1,
        ]);
    }

    public function test_existencia_de_registros_relacionados()
    {
        $carrera = Carrera::create([
            'Carrera' => 'Ingeniería en Sistemas',
        ]);

        $egresado = Egresado::create([
            'nombre' => 'Juan Perez',
            'año_egresado' => 2020,
            'fecha_nacimiento' => '1990-01-01',
            'identidad' => '12345678',
            'nro_expediente' => 1234,
            'gene_id' => 1,
            'carre_id' => $carrera->id,
        ]);

        $this->assertDatabaseHas('egresados', [
            'nombre' => 'Juan Perez',
            'carre_id' => $carrera->id,
        ]);
    }

    public function test_eliminacion_en_cascada()
    {
        $carrera = Carrera::create([
            'Carrera' => 'Ingeniería en Sistemas',
        ]);

        $egresado = Egresado::create([
            'nombre' => 'Juan Perez',
            'año_egresado' => 2020,
            'fecha_nacimiento' => '1990-01-01',
            'identidad' => '12345678',
            'nro_expediente' => 1234,
            'gene_id' => 1,
            'carre_id' => $carrera->id,
        ]);

        $carrera->delete();

        $this->assertDatabaseMissing('egresados', [
            'nombre' => 'Juan Perez',
            'carre_id' => $carrera->id,
        ]);
    }

    public function test_actualizacion_de_registros()
    {
        $carrera = Carrera::create([
            'Carrera' => 'Ingeniería en Sistemas',
        ]);

        $egresado = Egresado::create([
            'nombre' => 'Juan Perez',
            'año_egresado' => 2020,
            'fecha_nacimiento' => '1990-01-01',
            'identidad' => '12345678',
            'nro_expediente' => 1234,
            'gene_id' => 1,
            'carre_id' => $carrera->id,
        ]);

        $egresado->update([
            'nombre' => 'Pedro Perez',
        ]);

        $this->assertDatabaseHas('egresados', [
            'nombre' => 'Pedro Perez',
            'carre_id' => $carrera->id,
        ]);
    }

    public function test_consistencia_de_datos_despues_de_actualizacion()
    {
        $carrera = Carrera::create([
            'Carrera' => 'Ingeniería en Sistemas',
        ]);

        $egresado = Egresado::create([
            'nombre' => 'Juan Perez',
            'año_egresado' => 2020,
            'fecha_nacimiento' => '1990-01-01',
            'identidad' => '12345678',
            'nro_expediente' => 1234,
            'gene_id' => 1,
            'carre_id' => $carrera->id,
        ]);

        $egresado->update([
            'nombre' => 'Pedro Perez',
        ]);

        $this->assertDatabaseMissing('egresados', [
            'nombre' => 'Juan Perez',
            'carre_id' => $carrera->id,
        ]);
    }



    public function test_integridad_referencial()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        $egresado = Egresado::create([
            'nombre' => 'Juan Perez',
            'año_egresado' => 2020,
            'fecha_nacimiento' => '1990-01-01',
            'identidad' => '12345678',
            'nro_expediente' => 1234,
            'gene_id' => 1,
            'carre_id' => 9999, // Este ID no existe en la tabla carreras
        ]);
    }

    public function test_normalizacion_base_datos()
    {
        $carrera = Carrera::create([
            'Carrera' => 'Ingeniería en Sistemas',
        ]);

        $egresado1 = Egresado::create([
            'nombre' => 'Juan Perez',
            'año_egresado' => 2020,
            'fecha_nacimiento' => '1990-01-01',
            'identidad' => '12345678',
            'nro_expediente' => 1234,
            'gene_id' => 1,
            'carre_id' => $carrera->id,
        ]);

        $egresado2 = Egresado::create([
            'nombre' => 'Pedro Perez',
            'año_egresado' => 2020,
            'fecha_nacimiento' => '1990-01-01',
            'identidad' => '87654321',
            'nro_expediente' => 4321,
            'gene_id' => 1,
            'carre_id' => $carrera->id,
        ]);

        $this->assertDatabaseHas('egresados', [
            'nombre' => 'Juan Perez',
            'carre_id' => $carrera->id,
        ]);

        $this->assertDatabaseHas('egresados', [
            'nombre' => 'Pedro Perez',
            'carre_id' => $carrera->id,
        ]);
    }

    public function test_integridad_de_datos()
    {
        $carrera = Carrera::create([
            'Carrera' => 'Ingeniería en Sistemas',
        ]);

        $egresado = Egresado::create([
            'nombre' => 'Juan Perez',
            'año_egresado' => '2020', // Esto debería causar una excepción
            'fecha_nacimiento' => '1990-01-01',
            'identidad' => '12345678',
            'nro_expediente' => 1234,
            'gene_id' => 1,
            'carre_id' => $carrera->id,
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);
    }

    public function test_consistencia_de_datos()
    {
        $carrera = Carrera::create([
            'Carrera' => 'Ingeniería en Sistemas',
        ]);

        $egresado = Egresado::create([
            'nombre' => 'Juan Perez',
            'año_egresado' => date('Y') + 1, // Esto debería causar una excepción
            'fecha_nacimiento' => '1990-01-01',
            'identidad' => '12345678',
            'nro_expediente' => 1234,
            'gene_id' => 1,
            'carre_id' => $carrera->id,
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);
    }

    public function test_relaciones_entre_tablas()
    {
        $carrera = Carrera::create([
            'Carrera' => 'Ingeniería en Sistemas',
        ]);

        $egresado = Egresado::create([
            'nombre' => 'Juan Perez',
            'año_egresado' => 2020,
            'fecha_nacimiento' => '1990-01-01',
            'identidad' => '12345678',
            'nro_expediente' => 1234,
            'gene_id' => 1,
            'carre_id' => $carrera->id,
        ]);

        $carrera->delete();

        $this->assertDatabaseMissing('egresados', [
            'nombre' => 'Juan Perez',
            'carre_id' => $carrera->id,
        ]);
    }
}