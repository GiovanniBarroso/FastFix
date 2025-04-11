<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            [
                'nombre' => 'Pantalla iPhone 13',
                'description' => 'Pantalla OLED compatible con iPhone 13.',
                'precio' => 129.99,
                'stock' => 50,
                'activo' => true,
                'categories_id' => 1,
                'brands_id' => 1,
                'image' => 'pantalla-iphone13.jpg'
            ],
            [
                'nombre' => 'Disco SSD 1TB',
                'description' => 'Disco sólido rápido para portátiles o PC.',
                'precio' => 89.99,
                'stock' => 30,
                'activo' => true,
                'categories_id' => 2,
                'brands_id' => 2,
                'image' => 'ssd-1tb.jpg'
            ],
        ]);
    }
}
