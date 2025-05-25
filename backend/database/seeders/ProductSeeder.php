<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $productos = [
            ['iPhone 14 Pro Max', 'Smartphone de alta gama con excelente rendimiento', 1299.99],
            ['Samsung Galaxy Tab S8', 'Tablet Android con pantalla AMOLED y S-Pen', 799.99],
            ['Huawei MateBook D15', 'Portátil con diseño fino y procesador AMD Ryzen', 699.99],
            ['Xiaomi Mi 11 Lite', 'Smartphone ligero y potente con buena cámara', 349.99],
            ['PS5 Edición Digital', 'Consola de nueva generación sin lector de discos', 499.99],
            ['Teclado mecánico RGB MSI', 'Teclado para gaming con switches personalizables', 119.00],
            ['Asus ROG Zephyrus G14', 'Portátil gamer con gráfica dedicada y diseño compacto', 1499.00],
            ['Apple AirPods Pro', 'Auriculares inalámbricos con cancelación activa de ruido', 279.99],
            ['Nintendo Switch OLED', 'Consola híbrida con nueva pantalla mejorada', 359.00],
            ['Dell Ultrasharp Monitor', 'Monitor profesional con alta resolución y colores precisos', 449.00],
        ];

        $brands = Brand::all();
        $categories = Category::all();

        foreach ($productos as [$nombre, $descripcion, $precio]) {
            Product::create([
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'precio' => $precio,
                'stock' => rand(5, 50),
                'activo' => rand(0, 1), // 👈 aleatorio
                'brand_id' => $brands->random()->id,
                'category_id' => $categories->random()->id,
                'slug' => Str::slug($nombre . '-' . uniqid()), // 👈 más robusto que rand()
                'image' => 'placeholder.jpg', // 👈 puedes usar una imagen genérica si existe en /public/images
            ]);
        }
    }
}
