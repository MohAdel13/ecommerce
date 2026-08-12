<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use App\Utils\DTO;
use Illuminate\Http\Request;
use Modules\Product\Http\Requests\UpdateProductVariantRequest;
use Modules\Product\Models\ProductVariant;
use Modules\Product\Services\ProductVariantService;
use Modules\Product\Transformers\ProductDetailsResource;
use Modules\Product\Transformers\ProductResource;
use Modules\Product\Transformers\ProductVariantResource;

class ProductVariantController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        protected ProductVariantService $productVariantService
    ) {
    }

    public function show(ProductVariant $variant)
    {
        $variant->load('attributeValues.attribute');

        $data = new ProductVariantResource($variant);

        return $this->success(
            data: $data
        );
    }

    public function update(UpdateProductVariantRequest $request, ProductVariant $variant)
    {
        $dto = DTO::FromRequest($request, ['price', 'stock', 'sku', 'attributes']);

        $product = $this->productVariantService->update($variant, $dto);

        $data = new ProductDetailsResource($product);

        return $this->success(
            message: __('message.product_variant_updated'),
            data: $data
        );
    }

    public function delete(ProductVariant $variant)
    {
        $product = $this->productVariantService->delete($variant);

        $data = new ProductDetailsResource($product);

        return $this->success(
            message: __('message.product_variant_deleted'),
            data: $data
        );
    }
}