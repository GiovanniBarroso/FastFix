<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'Móviles', 'description' => 'Smartphones y accesorios', 'activo' => true],
            ['name' => 'Ordenadores', 'description' => 'Portátiles, sobremesa y componentes', 'activo' => true],
        ]);
    }
}
