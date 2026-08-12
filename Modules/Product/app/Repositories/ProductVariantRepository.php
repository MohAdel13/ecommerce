<?php
namespace Modules\Product\Repositories;

use App\Utils\DTO;
use Modules\Product\Models\ProductVariant;

class ProductVariantRepository
{
    public function query(DTO $dto)
    {
        return ProductVariant::query()->when($dto->product_id, fn($q) => $q->where('product_id', $dto->product_id));
    }

    public function getAll(DTO $dto)
    {
        return $this->query($dto)->get();
    }

    public function getPaginated(DTO $dto)
    {
        return $this->query($dto)->paginate(15, ['*'], 'page');
    }

    public function getBySku(string $sku)
    {
        return ProductVariant::with(['product'])->where('sku', $sku)->first();
    }

    public function create(array $data)
    {
        return ProductVariant::create($data);
    }

    public function update(ProductVariant $productVariant, array $data)
    {
        $productVariant->update($data);

        return $productVariant->fresh();
    }

    public function delete(ProductVariant $productVariant)
    {
        return $productVariant->delete();
    }

    public function syncVariantAttributeValues(ProductVariant $variant, array $valueIds)
    {
        $variant->attributeValues()->syncWithoutDetaching($valueIds);
    }
}