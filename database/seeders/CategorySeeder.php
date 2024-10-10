<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            'type'=> 'sport',
        'rate'=>'5'  
    ]);
    DB::table('categories')->insert([
        'type'=> 'cultueller',
        'rate'=>'4' 
    ]);
    DB::table('categories')->insert([
        'type'=> 'scientific',
        'rate'=>'7' 
    ]);
    DB::table('categories')->insert([
        'type'=> 'comedy',
        'rate'=>'8'
    ]);
    DB::table('categories')->insert([
        'type'=> 'political',
        'rate'=>'3'
    ]);
    }
}
