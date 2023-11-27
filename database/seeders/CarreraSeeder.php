<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Carrera;

class CarreraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        Carrera::create([

            'Carrera' => 'Bachillerato en Ciencias y Letras',
   
           
        ]);
   
        Carrera::create([
   
            'Carrera' => 'Bachillerato en Ciencias y Humanidades',
      
              
        ]);
 
        Carrera::create([
   
            'Carrera' => 'Perito Mercantil Y Contador Público',
      
              
        ]);

 
    }
}