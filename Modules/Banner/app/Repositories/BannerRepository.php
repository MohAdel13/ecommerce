<?php

namespace Modules\Banner\Repositories;

use Modules\Banner\Models\Banner;

class BannerRepository
{
    public function query()
    {
        return Banner::with('category')->latest();
    }

    public function getAll()
    {
        return $this->query()->get();
    }

    public function getPaginated()
    {
        return $this->query()->paginate(15, ['*'], 'page');
    }

    public function create(array $data)
    {
        return Banner::create($data);
    }

    public function update(Banner $banner, array $data)
    {
        $banner->update($data);

        return $banner->fresh(['category']);
    }

    public function delete(Banner $banner)
    {
        $banner->delete();
    }
}