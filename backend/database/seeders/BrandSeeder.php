<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    public function run()
    {
        DB::table('brands')->insert([
            ['name' => 'Apple', 'description' => 'Tecnología Apple', 'activo' => true],
            ['name' => 'Samsung', 'description' => 'Dispositivos Samsung', 'activo' => true],
        ]);
    }
}
