<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EdificioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('edificios')->insert([
            ['nombre' => 'CENTRAL'],
            ['nombre' => 'CONEJOS MEDANOS'],
            ['nombre' => 'HERMANOS ESCOBAR'],
            ['nombre' => 'SALVARCAR'],
            ['nombre' => 'PLANTA SUR'],
            ['nombre' => 'PTAR ANAPRA'],
            ['nombre' => 'ANAPRA'],
            ['nombre' => 'PARQUE CENTRAL'],
            ['nombre' => 'CONTINENTAL'],
            ['nombre' => 'INDEPENDENCIA'],
            ['nombre' => 'ALMACEN 4'],
            ['nombre' => 'ALMACEN 2'],
        ]);
    }
}
