<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            'Apple',
            'Samsung',
            'Huawei',
            'Xiaomi',
            'Sony',
            'HP',
            'MSI',
            'Asus',
            'Dell',
            'Nintendo'
        ];

        foreach ($brands as $brand) {
            Brand::create(['nombre' => $brand]);
        }
    }
}
