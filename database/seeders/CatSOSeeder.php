<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatSOSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cat_sos')->insert([
            
            ['nombre'=> 'Windows XP'],
            ['nombre'=> 'Windows 7',],
            ['nombre'=> 'Windows 10',],
            ['nombre'=> 'Windows 11',],
            ['nombre'=> 'Windows Server',],
            ['nombre'=> 'Linux',],
            ['nombre'=> 'Fedora',],
            ['nombre'=> 'Ubuntu',],
            ['nombre'=> 'Centos',],
            ['nombre'=> 'IOS',],
            ['nombre'=> 'Debian']
            
        ]);
    }
}
