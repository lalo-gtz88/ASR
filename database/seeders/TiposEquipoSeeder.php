<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposEquipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
      public function run(): void
    {
        $tipos = [

            ['nombre' => 'Desktop',   'active' => 1],
            ['nombre' => 'Laptop',    'active' => 1],
            ['nombre' => 'Impresora', 'active' => 1],
            ['nombre' => 'Telefono',  'active' => 1],
            ['nombre' => 'Tablet',    'active' => 1],
            ['nombre' => 'Switch',    'active' => 1],
            ['nombre' => 'Router',    'active' => 1],
            ['nombre' => 'Ap',        'active' => 1],
        ];

        DB::table('tipos_equipos')->insert($tipos);
    }
}
