<?php

namespace Modules\Promotion\Database\Seeders;

use App\Enums\DiscountType;
use Illuminate\Database\Seeder;
use Modules\Promotion\Models\Coupon;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        Coupon::insert([
            [
                'code' => 'WELCOME10',
                'discount_type' => DiscountType::PERCENTAGE->value,
                'discount_value' => 10,
                'usage_limit' => 1000,
                'usage_per_user' => 1,
                'starts_at' => $now,
                'ends_at' => $now->copy()->addMonths(3),
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'SAVE20',
                'discount_type' => DiscountType::PERCENTAGE->value,
                'discount_value' => 20,
                'usage_limit' => 500,
                'usage_per_user' => 2,
                'starts_at' => $now,
                'ends_at' => $now->copy()->addMonths(2),
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'FLASH30',
                'discount_type' => DiscountType::PERCENTAGE->value,
                'discount_value' => 30,
                'usage_limit' => 200,
                'usage_per_user' => 1,
                'starts_at' => $now,
                'ends_at' => $now->copy()->addDays(14),
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'FIXED500',
                'discount_type' => DiscountType::FIXED->value,
                'discount_value' => 500,
                'usage_limit' => 300,
                'usage_per_user' => 1,
                'starts_at' => $now,
                'ends_at' => $now->copy()->addMonth(),
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'VIP25',
                'discount_type' => DiscountType::PERCENTAGE->value,
                'discount_value' => 25,
                'usage_limit' => 200,
                'usage_per_user' => 1,
                'starts_at' => $now,
                'ends_at' => $now->copy()->addMonths(6),
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}