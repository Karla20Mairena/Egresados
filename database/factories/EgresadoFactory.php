<?php

namespace Database\Factories;

use App\Models\Carrera;
use App\Models\Genero;
use App\Models\Egresado;
use Illuminate\Database\Eloquent\Factories\Factory;

class EgresadoFactory extends Factory
{
    protected $model = Egresado::class;

   public function definition()
  {

    return [
        'nombre' => $this->faker->name,
        'año_egresado' => $this->faker->year,
        'fecha_nacimiento' => $this->faker->dateTimeBetween('-30 years', '2008-11-21')->format('Y-m-d'),
        'identidad' => $this->faker->unique()->numerify('#############'),
        'nro_expediente' => $this->faker->unique()->randomNumber(5),
        'gene_id' => function () {
            return Genero::inRandomOrder()->first()->id;
        },
        'carre_id' => function () {
            return Carrera::inRandomOrder()->first()->id;
        }, 
    ];
   }

}