<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
USE Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categorias')->insert([
            ['name' => 'CAMBIO DE PERFIL'],
            ['name' => 'INTERNET'],
            ['name' => 'CORREO'],
            ['name' => 'IMPRESORA'],
            ['name' => 'ESCANER'],
            ['name' => 'TELEFONIA'],
            ['name' => 'OFFICE'],
            ['name' => 'ACTIVACION WINDOWS'],
            ['name' => 'ANTIVIRUS'],
            ['name' => 'PC LENTA'],
            ['name' => 'MEMORIA'],
            ['name' => 'INSTALACION DE EQUIPO'],
        ]);

    }
}
