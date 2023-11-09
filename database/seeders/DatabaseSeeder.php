<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([CarreraSeeder::class]);
        $this->call([RoleSeeder::class]);
        $this->call([PermissionSeeder::class]);
        
        $this->call([RoleHasPermissionSeeder::class]);
        $this->call([UserSeeder::class]);
        $this->call([GeneroSeeder::class]);
        $this->call([EgresadoSeeder::class]);
    }
}
