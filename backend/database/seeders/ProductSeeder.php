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
                'name' => 'Pantalla iPhone 13',
                'description' => 'Pantalla OLED compatible con iPhone 13.',
                'price' => 129.99,
                'stock' => 50,
                'activo' => true,
                'category_id' => 1,
                'brand_id' => 1,
                'image' => 'pantalla-iphone13.jpg'
            ],
            [
                'name' => 'Disco SSD 1TB',
                'description' => 'Disco sólido rápido para portátiles o PC.',
                'price' => 89.99,
                'stock' => 30,
                'activo' => true,
                'category_id' => 2,
                'brand_id' => 2,
                'image' => 'ssd-1tb.jpg'
            ],
        ]);
    }
}
