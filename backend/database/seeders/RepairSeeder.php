<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Repair;
use App\Models\User;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Carbon\Carbon;

class RepairSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuario si no existe
        $user = User::first() ?? User::factory()->create();

        // Crear marca y categoría si no existen
        $brand = Brand::first() ?? Brand::factory()->create(['name' => 'Apple']);
        $category = Category::first() ?? Category::factory()->create(['name' => 'Pantallas']);

        // Crear producto si no existe
        $product = Product::first() ?? Product::create([
            'name' => 'Pantalla iPhone 11',
            'description' => 'Repuesto de pantalla original para iPhone 11.',
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'price' => 59.99,
            'stock' => 10,
        ]);

        // Crear reparaciones de ejemplo
        Repair::insert([
            [
                'user_id' => $user->id,
                'product_id' => $product->id,
                'device_type' => 'Móvil',
                'brand' => 'Apple',
                'model' => 'iPhone 11',
                'problem_description' => 'Pantalla rota tras caída.',
                'repair_notes' => 'Se reemplazó pantalla completa. Pruebas OK.',
                'status' => 'terminado',
                'repair_cost' => 75.50,
                'received_at' => Carbon::now()->subDays(5),
                'delivered_at' => Carbon::now()->subDays(2),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $user->id,
                'product_id' => null,
                'device_type' => 'Tablet',
                'brand' => 'Samsung',
                'model' => 'Galaxy Tab S6',
                'problem_description' => 'No carga correctamente.',
                'repair_notes' => 'Puerto de carga reemplazado.',
                'status' => 'entregado',
                'repair_cost' => 45.00,
                'received_at' => Carbon::now()->subDays(10),
                'delivered_at' => Carbon::now()->subDays(3),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $user->id,
                'product_id' => null,
                'device_type' => 'Consola',
                'brand' => 'Nintendo',
                'model' => 'Switch',
                'problem_description' => 'Joystick se mueve solo (drift).',
                'repair_notes' => 'Se reemplazaron los joy-cons.',
                'status' => 'pendiente',
                'repair_cost' => null,
                'received_at' => Carbon::now()->subDay(),
                'delivered_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
