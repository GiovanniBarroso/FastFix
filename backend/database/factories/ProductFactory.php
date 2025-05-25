<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $nombre = $this->faker->words(2, true);

        return [
            'nombre' => $nombre,
            'descripcion' => $this->faker->sentence(),
            'precio' => $this->faker->randomFloat(2, 10, 300),
            'stock' => $this->faker->numberBetween(0, 100),
            'activo' => $this->faker->boolean(90),
            'slug' => Str::slug($nombre . '-' . uniqid()), // 🔥 relacionado con el nombre y único
            'image' => null, // o genera una imagen de prueba si quieres
            'brand_id' => Brand::factory(),
            'category_id' => Category::factory(),
        ];
    }
}
