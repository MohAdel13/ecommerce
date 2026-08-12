<?php
namespace Modules\Product\Repositories;

use App\Utils\DTO;
use Modules\Product\Models\AttributeValue;
use Modules\Product\Models\Product;

class ProductRepository
{
    public function query(DTO $dto)
    {
        return Product::query()->with(['categories', 'variants', 'defaultVariant'])
            ->when(
                $dto->category_id,
                fn($q) => $q->whereHas(
                    'categories',
                    fn($q) => $q->where('categories.id', $dto->category_id)
                )
            )
            ->when(
                $dto->search,
                fn($q) => $q->where(function ($q) use ($dto) {
                    $q->where('name_en', 'like', "%{$dto->search}%")
                        ->orWhere('name_ar', 'like', "%{$dto->search}%")
                        ->orWhere('description_en', 'like', "%{$dto->search}%")
                        ->orWhere('description_ar', 'like', "%{$dto->search}%");
                })
            );
    }

    public function getAll(DTO $dto)
    {
        return $this->query($dto)->get();
    }

    public function getPaginated(DTO $dto)
    {
        return $this->query($dto)->paginate(15, ['*'], 'page');
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data)
    {
        $product->update($data);

        return $product->fresh();
    }

    public function delete(Product $product)
    {
        return $product->delete();
    }

    public function syncCategories(Product $product, array $categoryIds): void
    {
        $product->categories()->sync($categoryIds);
    }

    public function syncProductAttributes(Product $product, array $attributeIds)
    {
        $product->attributes()->syncWithoutDetaching(array_unique($attributeIds));
    }

    public function recomputeAndSyncAttributes(Product $product): void
    {
        $attributeIds = AttributeValue::whereHas('productVariants', function ($q) use ($product) {
            $q->where('product_id', $product->id);
        })->pluck('attribute_id')->unique();

        $product->attributes()->sync($attributeIds);
    }
}