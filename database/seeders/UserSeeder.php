<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'username' => 'admin13790tds',
                'name' => 'Administrador',
                'correo' => 'cosme@gmail.com',
                'nacimiento' => '19990909',
                'identidad' => '0000000000000',
                'telefono' => '00000000',
                'password' => bcrypt('cosme13790'),
            ]
        )->assignRole('Admin');

        User::create(
            [
                'name' => 'Martha Sanchez',
                'correo' => 'cosme2@gmail.com',
                'nacimiento' => '19990909',
                'identidad' => '0000000000001',
                'telefono' => '00000001',
                'username' => 'Martha Sanchez',
                'password' => bcrypt('cosmegc1976'),
            ]
        )->assignRole('Digitador');


    }
}
