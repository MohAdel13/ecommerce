<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaginationCollection;
use App\Traits\ApiResponseTrait;
use App\Utils\DTO;
use Illuminate\Http\Request;
use Modules\Product\Http\Requests\AddProductVariantsRequest;
use Modules\Product\Http\Requests\CreateProductRequest;
use Modules\Product\Http\Requests\GetProductsRequest;
use Modules\Product\Http\Requests\SyncProductCategoriesRequest;
use Modules\Product\Http\Requests\UpdateProductRequest;
use Modules\Product\Models\Product;
use Modules\Product\Services\ProductService;
use Modules\Product\Transformers\ProductDetailsResource;
use Modules\Product\Transformers\ProductResource;

class ProductController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private ProductService $productService)
    {
    }

    public function index(GetProductsRequest $request)
    {
        $dto = DTO::FromRequest($request, ['category_id', 'search']);
        $dto->append(['page' => $request->filled('page')]);

        $products = $this->productService->index($dto);

        $data = $request->filled('page') ? new PaginationCollection($products, 'products', ProductResource::class) :
            ProductResource::collection($products);

        return $this->success(
            data: $data
        );
    }

    public function create(CreateProductRequest $request)
    {
        $dto = DTO::FromRequest($request, ['name_en', 'name_ar', 'description_en', 'description_ar', 'price', 'sku', 'stock', 'features', 'images']);
        $product = $this->productService->create($dto);

        $data = new ProductResource($product);

        return $this->success(
            message: __('message.product_created'),
            data: $data
        );
    }

    public function show(Product $product)
    {
        $product->load(['categories', 'variants', 'defaultVariant']);

        $data = new ProductDetailsResource($product);

        return $this->success(
            data: $data
        );
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $dto = DTO::FromRequest($request, ['name_en', 'name_ar', 'description_en', 'description_ar', 'price', 'sku', 'stock', 'features', 'images', 'delete_images_ids']);
        $product = $this->productService->update($dto, $product);

        $data = new ProductDetailsResource($product);

        return $this->success(
            message: __('message.product_updated'),
            data: $data
        );
    }

    public function delete(Product $product)
    {
        $this->productService->delete($product);

        return $this->success(
            message: __('message.product_deleted')
        );
    }

    public function syncCategories(SyncProductCategoriesRequest $request, Product $product)
    {
        $dto = DTO::fromRequest($request, ['category_ids']);

        $product = $this->productService->syncCategories($dto, $product);

        return $this->success(
            message: __('message.product_updated'),
            data: new ProductDetailsResource($product)
        );
    }

    public function addVariants(AddProductVariantsRequest $request, Product $product)
    {
        $dto = DTO::fromRequest($request, ['variants']);

        $product = $this->productService->addVariants($product, $dto);

        return $this->success(
            message: __('message.product_updated'),
            data: new ProductDetailsResource($product)
        );
    }
}