<?php

namespace Database\Seeders;

use App\Models\TiposEquipo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoEquipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TiposEquipo::create([
            'nombre' => 'Desktop',
            'active' => 1,
        ]);

        TiposEquipo::create([
            'nombre' => 'Laptop',
            'active' => 1,
        ]);

        TiposEquipo::create([
            'nombre' => 'Impresora',
            'active' => 1,
        ]);

        TiposEquipo::create([
            'nombre' => 'Telefono',
            'active' => 1,
        ]);

        TiposEquipo::create([
            'nombre' => 'Tablet',
            'active' => 1,
        ]);

        TiposEquipo::create([
            'nombre' => 'Switch',
            'active' => 1,
        ]);

        TiposEquipo::create([
            'nombre' => 'Router',
            'active' => 1,
        ]);

        TiposEquipo::create([
            'nombre' => 'Ap',
            'active' => 1,
        ]);
    }
}
