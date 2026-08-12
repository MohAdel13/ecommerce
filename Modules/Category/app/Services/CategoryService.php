<?php
namespace Modules\Category\Services;

use App\Utils\DTO;
use Modules\Category\Models\Category;
use Modules\Category\Repositories\CategoryRepository;

class CategoryService
{
    public function __construct(private CategoryRepository $categoryRepository)
    {
    }

    public function index(bool $page, ?int $parent_id)
    {
        return $page ? $this->categoryRepository->getPaginated($parent_id) : $this->categoryRepository->getAll($parent_id);
    }

    public function create(DTO $dto)
    {
        $category = $this->categoryRepository->create($dto->getData());

        if ($dto->image) {
            $category->addMedia($dto->image)
                ->toMediaCollection('categories');
        }

        return $category->fresh();
    }

    public function update(Category $category, DTO $dto)
    {
        $category = $this->categoryRepository->update($category, $dto->getData());

        if ($dto->image) {
            $category->clearMediaCollection('categories');

            $category->addMedia($dto->image)
                ->toMediaCollection('categories');
        }

        return $category->fresh();
    }

    public function delete(Category $category)
    {
        $category->clearMediaCollection('categories');
        $this->categoryRepository->delete($category);
    }
}