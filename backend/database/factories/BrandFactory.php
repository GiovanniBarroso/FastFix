<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->company(),
            'description' => $this->faker->sentence(),
            'activo' => $this->faker->boolean(90), // 90% activo
        ];
    }
}
