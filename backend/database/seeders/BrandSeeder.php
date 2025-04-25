<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    public function run()
    {
        DB::table('brands')->insert([
            ['nombre' => 'Apple', 'descripcion' => 'Tecnología Apple', 'activo' => true],
            ['nombre' => 'Samsung', 'descripcion' => 'Dispositivos Samsung', 'activo' => true],
        ]);
    }
}
