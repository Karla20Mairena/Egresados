<?php

namespace Database\Factories;

use App\Models\Carrera;
use App\Models\Genero;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarreraFactory extends Factory
{
    protected $model = Carrera::class;

   public function definition()
  {

    return [
        'Carrera' => $this->faker->name,
    ];
   }

}
