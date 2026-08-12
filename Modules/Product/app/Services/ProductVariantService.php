<?php
namespace Modules\Product\Services;

use App\Exceptions\BusinessException;
use App\Utils\DTO;
use Illuminate\Support\Facades\DB;
use Modules\Product\Models\ProductVariant;
use Modules\Product\Repositories\AttributeRepository;
use Modules\Product\Repositories\ProductRepository;
use Modules\Product\Repositories\ProductVariantRepository;

class ProductVariantService
{
    public function __construct(
        private ProductVariantRepository $productVariantRepository,
        private AttributeRepository $attributeRepository,
        private ProductRepository $productRepository
    ) {
    }

    public function update(ProductVariant $variant, DTO $dto)
    {
        if ($variant->is_default) {
            throw new BusinessException(message: __('message.cannot_modify_default_variant'), code: 400, errors: [__('message.cannot_modify_default_variant')]);
        }
        $attributesCache = $this->attributeRepository->attributesCache();

        $valuesCache = $this->attributeRepository->valuesCache();

        return DB::transaction(function () use ($variant, $dto, &$attributesCache, &$valuesCache) {

            $product = $variant->product;

            $variant = $this->productVariantRepository->update($variant, [
                'price' => $dto->price,
                'stock' => $dto->stock,
                'sku' => $dto->sku
            ]);


            $valueIds = [];

            foreach ($dto->attributes as $attribute) {
                $attribute_name_en = strtolower($attribute['name_en']);
                $value_en = strtolower($attribute['value_en']);
                if (!isset($attributesCache[$attribute_name_en])) {
                    $attr = $this->attributeRepository->create($attribute['name_en'], $attribute['name_ar']);
                    $attributeId = $attr->id;

                    $value = $this->attributeRepository->createValue($attributeId, $attribute['value_en'], $attribute['value_ar']);
                    $valueId = $value->id;
                } else {
                    $attributeId = $attributesCache[$attribute_name_en];
                    if (!isset($valuesCache[$attribute_name_en][$value_en])) {
                        $value = $this->attributeRepository->createValue($attributeId, $attribute['value_en'], $attribute['value_ar']);
                        $valueId = $value->id;
                    } else {
                        $valueId = $valuesCache[$attribute_name_en][$value_en];
                    }
                }

                $valueIds[] = $valueId;

                $attributesCache[$attribute_name_en] = $attributeId;
                $valuesCache[$attribute_name_en][$value_en] = $valueId;
            }
            $this->productVariantRepository->syncVariantAttributeValues($variant, $valueIds);

            $this->productRepository->recomputeAndSyncAttributes($product);

            return $product->fresh()->load(['categories', 'defaultVariant', 'variants.attributeValues.attribute']);
        });
    }

    public function delete(ProductVariant $variant)
    {
        if ($variant->is_default) {
            throw new BusinessException(message: __('message.cannot_modify_default_variant'), code: 400, errors: [__('message.cannot_modify_default_variant')]);
        }
        return DB::transaction(function () use ($variant) {
            $product = $variant->product;

            $this->productVariantRepository->delete($variant);

            $this->productRepository->recomputeAndSyncAttributes($product);

            return $product->fresh()->load(['categories', 'defaultVariant', 'variants.attributeValues.attribute']);
        });
    }
}