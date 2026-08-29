<?php

namespace Modules\Category\Repositories;

use Modules\Category\Models\Category;

class CategoryRepository
{
    public function query(?int $parent_id = null)
    {
        return Category::query()->when($parent_id, fn($q) => $q->where('parent_id', $parent_id));
    }

    public function getAll(?int $parent_id = null)
    {
        return $this->query($parent_id)->get();
    }

    public function getPaginated(?int $parent_id = null)
    {
        return $this->query($parent_id)->paginate(15, ['*'], 'page');
    }

    public function update(Category $category, array $data)
    {
        $category->update($data);

        return $category;
    }

    public function create(array $data)
    {
        return Category::create($data);
    }

    public function delete(Category $category)
    {
        $category->delete();
    }

    public function getForHome()
    {
        return Category::with('parent')->get();
    }
}