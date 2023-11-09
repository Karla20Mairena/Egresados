<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'correo' => $this->faker->unique()->safeEmail,
            'nacimiento' => $this->faker->date,
            'username' => $this->faker->unique()->userName,
            'password' => bcrypt('password'), 
            'identidad' => $this->faker->unique()->isbn13,
            'telefono' => $this->faker->phoneNumber,
            'estado' => 1,
             
        ];
    }
}

