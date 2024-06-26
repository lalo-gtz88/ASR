<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Categoria;
use App\Models\CatSO;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         //\App\Models\User::factory(1)->create();
        //  \App\Models\Ticket::factory(10)->create();;
        //  \App\Models\Categoria::factory(10)->create();
        //  \App\Models\Seguimiento::factory(10)->create();
        $this->call([
            UserSeeder::class,
            CategoriaSeeder::class,
            EdificioSeeder::class,
            DepartamentoSeeder::class,
            CatSOSeeder::class,
        ]);
       
    }
}
