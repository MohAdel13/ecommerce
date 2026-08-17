<?php

namespace Modules\Promotion\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Promotion\Models\Offer;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        Offer::insert([
            [
                'code' => 'SUMMER10',
                'discount_value' => 10,
                'starts_at' => $now,
                'ends_at' => $now->copy()->addMonths(3),
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'SUMMER15',
                'discount_value' => 15,
                'starts_at' => $now,
                'ends_at' => $now->copy()->addMonths(2),
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'FLASH20',
                'discount_value' => 20,
                'starts_at' => $now,
                'ends_at' => $now->copy()->addMonth(),
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'FLASH25',
                'discount_value' => 25,
                'starts_at' => $now,
                'ends_at' => $now->copy()->addDays(14),
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'MEGA30',
                'discount_value' => 30,
                'starts_at' => $now,
                'ends_at' => $now->copy()->addDays(7),
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}