<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
                [ 
                    'name' => 'Administrador',
                    'lastname' => null,
                    'username'=> 'admin',
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                    'created_at' =>  Carbon::now(),
                    'updated_at' => Carbon::now()

                ],
                [ 
                    'name' => 'Eloy',
                    'lastname' => 'Garcia',
                    'username'=> 'egarlue',
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                    'created_at' =>  Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [ 
                    'name' => 'Daniela',
                    'lastname' => 'Morales',
                    'username'=> 'dmorales',
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                    'created_at' =>  Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [ 
                    'name' => 'Eduardo',
                    'lastname' => 'Gutierrez',
                    'username'=> 'egutierrez',
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                    'created_at' =>  Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [ 
                    'name' => 'David',
                    'lastname' => 'Ramirez',
                    'username'=> 'dramirez',
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                    'created_at' =>  Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [ 
                    'name' => 'Jorge',
                    'lastname' => 'Ramirez',
                    'username'=> 'jramirez',
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                    'created_at' =>  Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [ 
                    'name' => 'Alfredo',
                    'lastname' => 'Ramirez',
                    'username'=> 'aramirez',
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                    'created_at' =>  Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [ 
                    'name' => 'Marcos',
                    'lastname' => 'Rodriguez',
                    'username'=> 'mrodriguez',
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                    'created_at' =>  Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [ 
                    'name' => 'Luis',
                    'lastname' => 'Tarin',
                    'username'=> 'ltarin',
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                    'created_at' =>  Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
                
            ]);
    }
}
