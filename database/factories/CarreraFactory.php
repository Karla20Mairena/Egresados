<?php

namespace Database\Factories;

use App\Models\Carrera;
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
