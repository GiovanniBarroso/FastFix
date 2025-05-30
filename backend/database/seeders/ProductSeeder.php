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
            ['iPhone 14 Pro Max', 'Smartphone de alta gama con excelente rendimiento', 1299.99, '14promax.png'],
            ['Samsung Galaxy Tab S8', 'Tablet Android con pantalla AMOLED y S-Pen', 799.99, 'samsungtabs8.png'],
            ['Huawei MateBook D15', 'Portátil con diseño fino y procesador AMD Ryzen', 699.99, 'huaweid15.png'],
            ['Xiaomi Mi 11 Lite', 'Smartphone ligero y potente con buena cámara', 349.99, 'xiaomi11lite.png'],
            ['PS5 Edición Digital', 'Consola de nueva generación sin lector de discos', 499.99, 'ps5.png'],
            ['Teclado mecánico RGB MSI', 'Teclado para gaming con switches personalizables', 119.00, 'msikeyboard.png'],
            ['Asus ROG Zephyrus G14', 'Portátil gamer con gráfica dedicada y diseño compacto', 1499.00, 'asusrogg14.png'],
            ['Apple AirPods Pro', 'Auriculares inalámbricos con cancelación activa de ruido', 279.99, 'airpods.png'],
            ['Nintendo Switch OLED', 'Consola híbrida con nueva pantalla mejorada', 359.00, 'switch.png'],
            ['Dell Ultrasharp Monitor', 'Monitor profesional con alta resolución y colores precisos', 449.00, 'dellultra.png'],
            ['Logitech MX Master 3S', 'Ratón ergonómico avanzado con seguimiento láser y carga USB-C', 129.99, 'mxmaster3s.png'],
            ['Lenovo Legion 5 Pro', 'Portátil gaming con Ryzen 7 y pantalla WQXGA de 165Hz', 1399.00, 'legion5pro.png'],
        ];

        $brands = Brand::all();
        $categories = Category::all();

        foreach ($productos as [$nombre, $descripcion, $precioBase, $imagen]) {
            Product::create([
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'precio_base' => $precioBase,
                'precio' => $precioBase, // inicialmente sin descuento
                'stock' => rand(5, 50),
                'activo' => rand(0, 1),
                'brand_id' => $brands->random()->id,
                'category_id' => $categories->random()->id,
                'slug' => Str::slug($nombre . '-' . uniqid()),
                'image' => $imagen,
            ]);
        }
    }
}
