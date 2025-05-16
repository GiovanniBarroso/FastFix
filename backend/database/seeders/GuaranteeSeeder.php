<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guarantee;
use App\Models\User;
use App\Models\Product;
use Carbon\Carbon;

class GuaranteeSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $product = Product::first();

        if (!$user || !$product) {
            return;
        }

        foreach (range(1, 5) as $i) {
            $startDate = Carbon::now()->subMonths($i);
            $endDate = $startDate->copy()->addYear();

            Guarantee::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'fecha_inicio' => $startDate->toDateString(),
                'fecha_fin' => $endDate->toDateString(),
            ]);
        }
    }
}
