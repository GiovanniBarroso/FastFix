<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Smartphones',
            'Tablets',
            'Portátiles',
            'Sobremesa',
            'Consolas',
            'Accesorios',
            'Periféricos',
            'Repuestos'
        ];

        foreach ($categories as $category) {
            Category::create(['nombre' => $category]);
        }
    }
}
