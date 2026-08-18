<?php

namespace Modules\Tax\Repositories;

use Modules\Tax\Models\Tax;

class TaxRepository
{
    public function query()
    {
        return Tax::query()->latest();
    }

    public function getAll()
    {
        return $this->query()->get();
    }

    public function getPaginated()
    {
        return $this->query()->paginate(15, ['*'], 'page');
    }

    public function create(array $data): Tax
    {
        return Tax::create($data);
    }

    public function update(Tax $tax, array $data): Tax
    {
        $tax->update($data);

        return $tax->fresh();
    }

    public function delete(Tax $tax): void
    {
        $tax->delete();
    }
}