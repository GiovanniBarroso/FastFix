<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    public function run()
    {
        DB::table('brands')->insert([
            ['name' => 'Apple', 'descripcion' => 'Tecnología Apple', 'activo' => true],
            ['name' => 'Samsung', 'descripcion' => 'Dispositivos Samsung', 'activo' => true],
        ]);
    }
}
