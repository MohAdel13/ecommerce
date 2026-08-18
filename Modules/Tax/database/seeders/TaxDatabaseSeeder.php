<?php

namespace Modules\Tax\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Product\Models\Product;
use Modules\Tax\Models\Tax;

class TaxDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vat = Tax::firstOrCreate(
            [
                'name_en' => 'VAT',
                'name_ar' => 'ضريبة القيمة المضافة',
            ],
            [
                'rate' => 14,
                'is_active' => true,
            ]
        );

        Product::query()->update([
            'tax_id' => $vat->id,
        ]);
    }
}