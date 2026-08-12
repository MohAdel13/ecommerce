<?php

namespace Modules\Category\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaginationCollection;
use App\Traits\ApiResponseTrait;
use App\Utils\DTO;
use Modules\Category\Http\Requests\CreateCategoryRequest;
use Modules\Category\Http\Requests\GetCategoriesRequest;
use Modules\Category\Http\Requests\UpdateCategoryRequest;
use Modules\Category\Models\Category;
use Modules\Category\Services\CategoryService;
use Modules\Category\Transformers\CategoryResource;

class CategoryController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private CategoryService $categoryService)
    {
    }

    public function index(GetCategoriesRequest $request)
    {
        $categories = $this->categoryService->index($request->filled('page'), $request->parent_id);

        $data = $request->filled('page') ? new PaginationCollection($categories, 'categories', CategoryResource::class) :
            CategoryResource::collection($categories);

        return $this->success(
            data: $data
        );
    }

    public function show(Category $category)
    {
        $data = new CategoryResource($category);

        return $this->success(
            data: $data
        );
    }

    public function create(CreateCategoryRequest $request)
    {
        $dto = DTO::FromRequest($request, ['name_en', 'name_ar', 'parent_id', 'image']);
        $category = $this->categoryService->create($dto);

        $data = new CategoryResource($category);

        return $this->success(
            message: __('message.category_created'),
            data: $data
        );
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $dto = DTO::FromRequest($request, ['name_en', 'name_ar', 'parent_id', 'image']);
        $category = $this->categoryService->update($category, $dto);

        $data = new CategoryResource($category);

        return $this->success(
            message: __('message.category_updated'),
            data: $data
        );
    }

    public function delete(Category $category)
    {
        $this->categoryService->delete($category);

        return $this->success(
            message: __('message.category_deleted'),
        );
    }
}