<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
            'brand_id' => Brand::factory(), // genera una marca asociada
            'category_id' => Category::factory(), // genera categoría
            'price' => $this->faker->randomFloat(2, 10, 300),
            'stock' => $this->faker->numberBetween(0, 100),
        ];
    }
}
