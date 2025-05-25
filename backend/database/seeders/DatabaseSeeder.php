<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            AddressSeeder::class,

            BrandSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            DiscountSeeder::class,

            RepairSeeder::class,
            BudgetSeeder::class,
            FavoriteSeeder::class,
            CartItemsSeeder::class,

            OrderSeeder::class,
            InvoiceSeeder::class,
        ]);
    }
}
