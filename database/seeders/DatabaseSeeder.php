<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Banner\Database\Seeders\BannerDatabaseSeeder;
use Modules\Category\Database\Seeders\CategoryDatabaseSeeder;
use Modules\Product\Database\Seeders\ProductDatabaseSeeder;
use Modules\Product\Database\Seeders\ProductVariantSeeder;
use Modules\Promotion\Database\Seeders\PromotionDatabaseSeeder;
use Modules\Tax\Database\Seeders\TaxDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->call(CategoryDatabaseSeeder::class);
        // $this->call(ProductDatabaseSeeder::class);
        // $this->call(ProductVariantSeeder::class);
        // $this->call(BannerDatabaseSeeder::class);
        // $this->call(PromotionDatabaseSeeder::class);
        $this->call(TaxDatabaseSeeder::class);
    }
}