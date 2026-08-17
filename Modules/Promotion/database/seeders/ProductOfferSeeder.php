<?php

namespace Modules\Promotion\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Product\Models\Product;
use Modules\Promotion\Models\Offer;

class ProductOfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $offers = Offer::pluck('id', 'code');

        $products = Product::with('defaultVariant')
            ->get()
            ->keyBy(fn(Product $product) => $product->defaultVariant?->sku);

        DB::table('product_offers')->insert([
            // iPhone 15 Pro → 10%, 20%, 25%
            [
                'product_id' => $products['IPH15PRO-001']->id,
                'offer_id' => $offers['SUMMER10'],
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'product_id' => $products['IPH15PRO-001']->id,
                'offer_id' => $offers['FLASH20'],
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'product_id' => $products['IPH15PRO-001']->id,
                'offer_id' => $offers['FLASH25'],
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Samsung Galaxy S24 → 15%, 30%
            [
                'product_id' => $products['SAM-S24-001']->id,
                'offer_id' => $offers['SUMMER15'],
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'product_id' => $products['SAM-S24-001']->id,
                'offer_id' => $offers['MEGA30'],
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // MacBook Air M3 → 10%, 15%
            [
                'product_id' => $products['MBA-M3-001']->id,
                'offer_id' => $offers['SUMMER10'],
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'product_id' => $products['MBA-M3-001']->id,
                'offer_id' => $offers['SUMMER15'],
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}