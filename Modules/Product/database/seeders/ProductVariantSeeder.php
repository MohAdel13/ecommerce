<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Product\Models\Attribute;
use Modules\Product\Models\AttributeValue;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductVariant;

class ProductVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * NOTE: Must run AFTER ProductDatabaseSeeder, since products/default
     * variants are looked up by the SKU created there.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $attributes = $this->seedAttributes();

            // Keyed by the DEFAULT variant SKU from ProductDatabaseSeeder.
            // Each entry is a list of *additional* (non-default) variants.
            $variantsData = [

                // --- Mobile Phones (Color + Storage) ---
                'IPH15PRO-001' => [
                    ['color' => 'Black', 'storage' => '256GB', 'price' => 49999, 'stock' => 15, 'sku' => 'IPH15PRO-256-BLK'],
                    ['color' => 'Black', 'storage' => '512GB', 'price' => 56999, 'stock' => 10, 'sku' => 'IPH15PRO-512-BLK'],
                    ['color' => 'White', 'storage' => '256GB', 'price' => 49999, 'stock' => 12, 'sku' => 'IPH15PRO-256-WHT'],
                    ['color' => 'Blue', 'storage' => '128GB', 'price' => 46999, 'stock' => 18, 'sku' => 'IPH15PRO-128-BLU'],
                ],
                'SAM-S24-001' => [
                    ['color' => 'Black', 'storage' => '128GB', 'price' => 39999, 'stock' => 20, 'sku' => 'SAMS24-128-BLK'],
                    ['color' => 'White', 'storage' => '256GB', 'price' => 43999, 'stock' => 14, 'sku' => 'SAMS24-256-WHT'],
                    ['color' => 'Silver', 'storage' => '256GB', 'price' => 43999, 'stock' => 9, 'sku' => 'SAMS24-256-SLV'],
                ],
                'PIXEL9-001' => [
                    ['color' => 'Black', 'storage' => '128GB', 'price' => 34999, 'stock' => 16, 'sku' => 'PIXEL9-128-BLK'],
                    ['color' => 'Blue', 'storage' => '256GB', 'price' => 38999, 'stock' => 11, 'sku' => 'PIXEL9-256-BLU'],
                ],

                // --- Laptops (Color + Storage) ---
                'MBA-M3-001' => [
                    ['color' => 'Silver', 'storage' => '256GB', 'price' => 64999, 'stock' => 9, 'sku' => 'MBAM3-256-SLV'],
                    ['color' => 'Silver', 'storage' => '512GB', 'price' => 74999, 'stock' => 6, 'sku' => 'MBAM3-512-SLV'],
                    ['color' => 'Black', 'storage' => '512GB', 'price' => 74999, 'stock' => 5, 'sku' => 'MBAM3-512-BLK'],
                ],
                'DELL-XPS15-001' => [
                    ['color' => 'Silver', 'storage' => '512GB', 'price' => 72999, 'stock' => 7, 'sku' => 'XPS15-512-SLV'],
                    ['color' => 'Black', 'storage' => '512GB', 'price' => 72999, 'stock' => 5, 'sku' => 'XPS15-512-BLK'],
                ],

                // --- Headphones (Color only) ---
                'SONY-XM5-001' => [
                    ['color' => 'Black', 'price' => 15999, 'stock' => 12, 'sku' => 'SONYXM5-BLK'],
                    ['color' => 'Silver', 'price' => 15999, 'stock' => 8, 'sku' => 'SONYXM5-SLV'],
                ],
                'AIRPODS-PRO2-001' => [
                    ['color' => 'White', 'price' => 10999, 'stock' => 25, 'sku' => 'AIRPODSP2-WHT'],
                ],

                // --- Men's Clothing (Size + Color) ---
                'MENS-TSHIRT-001' => [
                    ['size' => 'S', 'color' => 'Black', 'price' => 599, 'stock' => 30, 'sku' => 'MTSHIRT-S-BLK'],
                    ['size' => 'M', 'color' => 'Black', 'price' => 599, 'stock' => 40, 'sku' => 'MTSHIRT-M-BLK'],
                    ['size' => 'L', 'color' => 'White', 'price' => 599, 'stock' => 25, 'sku' => 'MTSHIRT-L-WHT'],
                    ['size' => 'XL', 'color' => 'White', 'price' => 599, 'stock' => 15, 'sku' => 'MTSHIRT-XL-WHT'],
                ],
                'MENS-JEANS-001' => [
                    ['size' => 'M', 'color' => 'Blue', 'price' => 1299, 'stock' => 25, 'sku' => 'MJEANS-M-BLU'],
                    ['size' => 'L', 'color' => 'Blue', 'price' => 1299, 'stock' => 20, 'sku' => 'MJEANS-L-BLU'],
                    ['size' => 'L', 'color' => 'Black', 'price' => 1299, 'stock' => 15, 'sku' => 'MJEANS-L-BLK'],
                ],

                // --- Women's Clothing (Size + Color) ---
                'WOMEN-DRESS-001' => [
                    ['size' => 'S', 'color' => 'Red', 'price' => 1499, 'stock' => 15, 'sku' => 'WDRESS-S-RED'],
                    ['size' => 'M', 'color' => 'Red', 'price' => 1499, 'stock' => 18, 'sku' => 'WDRESS-M-RED'],
                    ['size' => 'M', 'color' => 'Blue', 'price' => 1499, 'stock' => 12, 'sku' => 'WDRESS-M-BLU'],
                ],
                'WOMEN-HOODIE-001' => [
                    ['size' => 'S', 'color' => 'Black', 'price' => 999, 'stock' => 20, 'sku' => 'WHOODIE-S-BLK'],
                    ['size' => 'M', 'color' => 'White', 'price' => 999, 'stock' => 18, 'sku' => 'WHOODIE-M-WHT'],
                ],

                // --- Shoes (Shoe Size + Color) ---
                'NIKE-AIRMAX-001' => [
                    ['size' => '40', 'color' => 'Black', 'price' => 4999, 'stock' => 12, 'sku' => 'NIKEAIRMAX-40-BLK'],
                    ['size' => '41', 'color' => 'Black', 'price' => 4999, 'stock' => 15, 'sku' => 'NIKEAIRMAX-41-BLK'],
                    ['size' => '42', 'color' => 'White', 'price' => 4999, 'stock' => 10, 'sku' => 'NIKEAIRMAX-42-WHT'],
                    ['size' => '43', 'color' => 'White', 'price' => 4999, 'stock' => 8, 'sku' => 'NIKEAIRMAX-43-WHT'],
                ],
                'ADIDAS-RUN-001' => [
                    ['size' => '41', 'color' => 'Black', 'price' => 3999, 'stock' => 14, 'sku' => 'ADIDASRUN-41-BLK'],
                    ['size' => '42', 'color' => 'Blue', 'price' => 3999, 'stock' => 11, 'sku' => 'ADIDASRUN-42-BLU'],
                ],
            ];

            foreach ($variantsData as $defaultSku => $variants) {
                $product = ProductVariant::where('sku', $defaultSku)
                    ->firstOrFail()
                    ->product;

                $usedAttributeIds = [];

                foreach ($variants as $variantData) {
                    $variant = ProductVariant::create([
                        'product_id' => $product->id,
                        'price' => $variantData['price'],
                        'stock' => $variantData['stock'],
                        'sku' => $variantData['sku'],
                        'is_default' => false,
                    ]);

                    $attributeValueIds = [];

                    foreach (['color', 'storage', 'size'] as $attrKey) {
                        if (!isset($variantData[$attrKey])) {
                            continue;
                        }

                        $attributeValueIds[] = $attributes[$attrKey]['values'][$variantData[$attrKey]];
                        $usedAttributeIds[$attributes[$attrKey]['id']] = true;
                    }

                    $variant->attributeValues()->sync($attributeValueIds);
                }

                // Link the attribute TYPES (not values) used by this product's variants.
                $product->attributes()->syncWithoutDetaching(array_keys($usedAttributeIds));
            }
        });
    }

    /**
     * Create (or reuse) the Attribute + AttributeValue records
     * and return a lookup map: attributeKey => ['id' => ..., 'values' => [label => valueId]]
     */
    private function seedAttributes(): array
    {
        $definitions = [
            'color' => [
                'name_en' => 'Color',
                'name_ar' => 'اللون',
                'values' => [
                    'Black' => ['value_en' => 'Black', 'value_ar' => 'أسود'],
                    'White' => ['value_en' => 'White', 'value_ar' => 'أبيض'],
                    'Blue' => ['value_en' => 'Blue', 'value_ar' => 'أزرق'],
                    'Silver' => ['value_en' => 'Silver', 'value_ar' => 'فضي'],
                    'Red' => ['value_en' => 'Red', 'value_ar' => 'أحمر'],
                ],
            ],
            'storage' => [
                'name_en' => 'Storage',
                'name_ar' => 'سعة التخزين',
                'values' => [
                    '128GB' => ['value_en' => '128GB', 'value_ar' => '128 جيجابايت'],
                    '256GB' => ['value_en' => '256GB', 'value_ar' => '256 جيجابايت'],
                    '512GB' => ['value_en' => '512GB', 'value_ar' => '512 جيجابايت'],
                ],
            ],
            'size' => [
                'name_en' => 'Size',
                'name_ar' => 'المقاس',
                'values' => [
                    'S' => ['value_en' => 'S', 'value_ar' => 'صغير'],
                    'M' => ['value_en' => 'M', 'value_ar' => 'متوسط'],
                    'L' => ['value_en' => 'L', 'value_ar' => 'كبير'],
                    'XL' => ['value_en' => 'XL', 'value_ar' => 'كبير جدًا'],
                    '40' => ['value_en' => '40', 'value_ar' => '40'],
                    '41' => ['value_en' => '41', 'value_ar' => '41'],
                    '42' => ['value_en' => '42', 'value_ar' => '42'],
                    '43' => ['value_en' => '43', 'value_ar' => '43'],
                ],
            ],
        ];

        $result = [];

        foreach ($definitions as $key => $def) {
            $attribute = Attribute::firstOrCreate(
                ['name_en' => $def['name_en']],
                ['name_ar' => $def['name_ar']]
            );

            $values = [];

            foreach ($def['values'] as $label => $valueData) {
                $attributeValue = AttributeValue::firstOrCreate(
                    [
                        'attribute_id' => $attribute->id,
                        'value_en' => $valueData['value_en'],
                    ],
                    ['value_ar' => $valueData['value_ar']]
                );

                $values[$label] = $attributeValue->id;
            }

            $result[$key] = [
                'id' => $attribute->id,
                'values' => $values,
            ];
        }

        return $result;
    }
}