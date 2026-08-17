<?php

namespace Modules\Promotion\Database\Seeders;

use Illuminate\Database\Seeder;

class PromotionDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(OfferSeeder::class);
        $this->call(ProductOfferSeeder::class);
        $this->call(CouponSeeder::class);
    }
}