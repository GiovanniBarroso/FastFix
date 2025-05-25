<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'activo' => $this->faker->boolean(90),
        ];
    }
}
