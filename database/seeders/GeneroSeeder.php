<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Genero;

class GeneroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $generos = [

            'Femenino',
            'Masculino',
   
           
        ];
        foreach($generos as $genero){
               Genero::create([
                   'name'=> $genero
               ]);
   
               
        }
    }
}
