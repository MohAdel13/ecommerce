<?php
namespace Modules\Product\Repositories;

use Illuminate\Support\Facades\Cache;
use Modules\Product\Models\Attribute;
use Modules\Product\Models\AttributeValue;

class AttributeRepository
{
    public function attributesCache(): array
    {
        return Cache::remember(
            'product.attributes.cache',
            now()->addHours(24),
            fn() => Attribute::pluck('id', 'name_en')
                ->mapWithKeys(
                    fn($id, $name) => [strtolower($name) => $id]
                )
                ->toArray()
        );
    }

    public function valuesCache(): array
    {
        return Cache::remember(
            'product.attribute_values.cache',
            now()->addHours(24),
            fn() => AttributeValue::with('attribute:id,name_en')
                ->get()
                ->groupBy(
                    fn($value) => strtolower($value->attribute->name_en)
                )
                ->map(
                    fn($values) => $values->mapWithKeys(
                        fn($value) => [
                            strtolower($value->value_en) => $value->id
                        ]
                    )
                )
                ->toArray()
        );
    }

    public function create(string $name_en, string $name_ar)
    {
        $attribute = Attribute::create([
            'name_en' => $name_en,
            'name_ar' => $name_ar,
        ]);

        Cache::forget('product.attributes.cache');

        return $attribute;
    }

    public function createValue(int $attributeId, string $value_en, string $value_ar)
    {
        $value = AttributeValue::create(
            [
                'attribute_id' => $attributeId,
                'value_en' => $value_en,
                'value_ar' => $value_ar,
            ]
        );

        Cache::forget('product.attribute_values.cache');

        return $value;
    }
}