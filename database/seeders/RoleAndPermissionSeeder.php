<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'Seccion usuarios']);
        Permission::create(['name' => 'Mostrar todos los tickets']);
        Permission::create(['name' => 'Recibir notificación de todos los tickets']);
        
    }
}
