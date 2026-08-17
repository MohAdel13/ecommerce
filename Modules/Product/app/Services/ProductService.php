<?php
namespace Modules\Product\Services;

use App\Utils\DTO;
use Illuminate\Support\Facades\DB;
use Modules\Product\Models\Product;
use Modules\Product\Repositories\AttributeRepository;
use Modules\Product\Repositories\ProductRepository;
use Modules\Product\Repositories\ProductVariantRepository;

class ProductService
{
    public function __construct(
        private ProductRepository $productRepository,
        private ProductVariantRepository $productVariantRepository,
        private AttributeRepository $attributeRepository
    ) {
    }

    public function index(DTO $dto)
    {
        return $dto->page ? $this->productRepository->getPaginated($dto) : $this->productRepository->getAll($dto);
    }

    public function create(DTO $dto)
    {
        return DB::transaction(function () use ($dto) {
            $product_data = [
                'name_en' => $dto->name_en,
                'name_ar' => $dto->name_ar,
                'description_en' => $dto->description_en,
                'description_ar' => $dto->description_ar,
                'features' => $dto->features,
            ];
            $product = $this->productRepository->create($product_data);

            $variant_data = [
                'price' => $dto->price,
                'stock' => $dto->stock,
                'sku' => $dto->sku,
                'product_id' => $product->id,
                'is_default' => true,
            ];

            $this->productVariantRepository->create($variant_data);

            if ($dto->images) {
                foreach ($dto->images as $image) {
                    $product->addMedia($image)
                        ->toMediaCollection('products');
                }
            }

            return $product->fresh()->load(['defaultVariant']);
        });
    }

    public function update(DTO $dto, Product $product)
    {
        return DB::transaction(function () use ($dto, $product) {
            $product_data = [
                'name_en' => $dto->name_en,
                'name_ar' => $dto->name_ar,
                'description_en' => $dto->description_en,
                'description_ar' => $dto->description_ar,
                'features' => $dto->features,
            ];
            $product = $this->productRepository->update($product, $product_data);

            $variant_data = [
                'price' => $dto->price,
                'stock' => $dto->stock,
                'sku' => $dto->sku,
            ];

            $variant = $product->defaultVariant;

            $this->productVariantRepository->update($variant, $variant_data);

            if ($dto->delete_images_ids) {
                $product->media()
                    ->whereIn('id', $dto->delete_images_ids)
                    ->get()
                    ->each
                    ->delete();
            }

            if ($dto->images) {
                foreach ($dto->images as $image) {
                    $product->addMedia($image)
                        ->toMediaCollection('products');
                }
            }

            return $product->fresh()->load(['offers', 'categories', 'defaultVariant', 'variants.attributeValues.attribute']);
        });
    }

    public function delete(Product $product)
    {
        $product->clearMediaCollection('products');

        $this->productRepository->delete($product);
    }

    public function addVariants(Product $product, DTO $dto)
    {
        $attributesCache = $this->attributeRepository->attributesCache();

        $valuesCache = $this->attributeRepository->valuesCache();

        return DB::transaction(function () use ($dto, &$attributesCache, &$valuesCache, $product) {
            $allAttributeIds = [];

            $variants = $dto->variants;
            foreach ($variants as $var) {
                $variant = $this->productVariantRepository->create([
                    'product_id' => $product->id,
                    'price' => $var['price'],
                    'stock' => $var['stock'],
                    'sku' => $var['sku'],
                ]);


                $attributeIds = [];
                $valueIds = [];

                foreach ($var['attributes'] as $attribute) {
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

                    $attributeIds[] = $attributeId;
                    $valueIds[] = $valueId;

                    $attributesCache[$attribute_name_en] = $attributeId;
                    $valuesCache[$attribute_name_en][$value_en] = $valueId;
                }
                $this->productVariantRepository->syncVariantAttributeValues($variant, $valueIds);
                $allAttributeIds = array_merge($allAttributeIds, $attributeIds);
            }
            $this->productRepository->syncProductAttributes($product, $allAttributeIds);

            return $product->fresh()->load(['offers', 'categories', 'defaultVariant', 'variants.attributeValues.attribute']);
        });
    }

    public function syncCategories(DTO $dto, Product $product)
    {
        $this->productRepository->syncCategories($product, $dto->category_ids);

        return $product->fresh()->load(['offers', 'categories', 'variants', 'defaultVariant']);
    }

    public function syncOffers(Product $product, array $offerIds)
    {
        $this->productRepository->syncOffers($product, $offerIds);

        return $product->fresh(['offers', 'categories', 'variants', 'defaultVariant']);
    }
}