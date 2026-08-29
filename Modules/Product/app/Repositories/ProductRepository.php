<?php
namespace Modules\Product\Repositories;

use App\Utils\DTO;
use Modules\Product\Models\AttributeValue;
use Modules\Product\Models\Product;

class ProductRepository
{
    public function query(DTO $dto)
    {
        return Product::query()->with(['offers', 'categories', 'variants', 'defaultVariant'])
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
            )->when(
                $dto->max_offers,
                function ($q) {
                    $q->withMax(
                        [
                            'offers as best_offer_percentage' => function ($q) {
                                $q->where('is_active', true)
                                    ->where('starts_at', '<=', now())
                                    ->where(function ($q) {
                                        $q->whereNull('ends_at')
                                            ->orWhere('ends_at', '>=', now());
                                    });
                            }
                        ],
                        'discount_value'
                    )
                        ->whereHas('offers', function ($q) {
                            $q->where('is_active', true)
                                ->where('starts_at', '<=', now())
                                ->where(function ($q) {
                                    $q->whereNull('ends_at')
                                        ->orWhere('ends_at', '>=', now());
                                });
                        })
                        ->orderByDesc('best_offer_percentage');
                }
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

    public function syncOffers(Product $product, array $offerIds): void
    {
        $product->offers()->sync($offerIds);
    }

    public function getBestOffers(int $limit = 10)
    {
        return Product::with(['offers', 'categories', 'variants', 'defaultVariant'])
            ->whereHas('offers', function ($q) {
                $q->where('is_active', true)
                    ->where('starts_at', '<=', now())
                    ->where(function ($q) {
                        $q->whereNull('ends_at')
                            ->orWhere('ends_at', '>=', now());
                    });
            })
            ->withMax(
                [
                    'offers as best_discount' => function ($q) {
                        $q->where('is_active', true)
                            ->where('starts_at', '<=', now())
                            ->where(function ($q) {
                                $q->whereNull('ends_at')
                                    ->orWhere('ends_at', '>=', now());
                            });
                    },
                ],
                'discount_value'
            )
            ->orderByDesc('best_discount')
            ->take($limit)
            ->get();
    }

    public function getBestSelling(int $limit = 10)
    {
        return Product::with([
            'offers',
            'categories',
            'variants',
            'defaultVariant',
        ])
            ->withSum('orderItems as sold_count', 'quantity')
            ->orderByDesc('sold_count')
            ->take($limit)
            ->get();
    }
}