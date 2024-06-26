<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departamentos')->insert([
            ['nombre' => 'Registro de usuarios'],
            ['nombre' => 'Tecnologias de la información'],
            ['nombre' => 'Medición'],
            ['nombre' => 'Juridico'],
            ['nombre' => 'Recuperación juridica'],
            ['nombre' => 'PEM'],
            ['nombre' => 'Comunicación social'],
            ['nombre' => 'Presupuestos'],
            ['nombre' => 'Dirección comercial'],
            ['nombre' => 'Dirección financiera'],
            ['nombre' => 'Recursos humanos'],
            ['nombre' => 'Ingresos'],
            ['nombre' => 'Cajas'],
            ['nombre' => 'Recepcion'],
            ['nombre' => 'Planeación'],
            ['nombre' => 'Dirección operativa'],
            ['nombre' => 'Extracción y distribución'],
            ['nombre' => 'Compras'],
            ['nombre' => 'Licitaciones'],
            ['nombre' => 'Estudio de mercado'],
            ['nombre' => 'Normatividad'],
            ['nombre' => 'Transparencia'],
            ['nombre' => 'Control de obras'],
            ['nombre' => 'Contabilidad'],
            ['nombre' => 'Seguridad y transporte'],
            ['nombre' => 'Atencion multiple'],
            ['nombre' => 'Dirección ejecutiva'],
            ['nombre' => 'Dirección administrativa'],
            ['nombre' => 'CAT'],
            ['nombre' => 'Cultura del agua'],
            ['nombre' => 'Agua tratada'],
        ]);
    }
}
