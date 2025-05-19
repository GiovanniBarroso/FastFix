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
                'image' => 'pantalla-iphone13.webp'
            ],
            [
                'name' => 'Disco SSD 1TB',
                'description' => 'Disco sólido rápido para portátiles o PC.',
                'price' => 89.99,
                'stock' => 30,
                'activo' => true,
                'category_id' => 2,
                'brand_id' => 2,
                'image' => 'disco-ssd-1tb.webp'
            ],
            [
                'name' => 'Cable USB-C trenzado',
                'description' => 'Cable reforzado para carga rápida.',
                'price' => 5.95,
                'stock' => 120,
                'activo' => true,
                'category_id' => 1,
                'brand_id' => 2,
                'image' => 'cable-usb-c-trenzado.jpg'
            ],
            [
                'name' => 'Funda antigolpes iPhone 14',
                'description' => 'Protección extra resistente y flexible.',
                'price' => 12.50,
                'stock' => 75,
                'activo' => true,
                'category_id' => 1,
                'brand_id' => 1,
                'image' => 'funda-antigolpes-iphone14.jpg'
            ]
        ]);
    }
}
