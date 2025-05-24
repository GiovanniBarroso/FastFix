<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guarantee;
use App\Models\User;
use App\Models\Repair;
use Carbon\Carbon;

class GuaranteeSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $repairs = Repair::where('user_id', $user?->id)->take(5)->get();

        if (!$user || $repairs->isEmpty()) {
            return;
        }

        foreach ($repairs as $i => $repair) {
            $startDate = Carbon::now()->subMonths($i);
            $endDate = $startDate->copy()->addMonths(6); // Garantía de 6 meses

            Guarantee::create([
                'user_id' => $user->id,
                'repair_id' => $repair->id, // ✅ ya no se usa product_id
                'fecha_inicio' => $startDate->toDateString(),
                'fecha_fin' => $endDate->toDateString(),
            ]);
        }
    }
}
