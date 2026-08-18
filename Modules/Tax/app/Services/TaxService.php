<?php

namespace Modules\Tax\Services;

use App\Utils\DTO;
use Modules\Tax\Models\Tax;
use Modules\Tax\Repositories\TaxRepository;

class TaxService
{

    public function __construct(
        private TaxRepository $taxRepository
    ) {
    }

    public function index(?bool $page = false)
    {
        return $page ? $this->taxRepository->getPaginated()
            : $this->taxRepository->getAll();
    }

    public function create(DTO $dto)
    {
        return $this->taxRepository->create($dto->getData());
    }

    public function update(Tax $tax, DTO $dto)
    {
        return $this->taxRepository->update($tax, $dto->getData());
    }

    public function delete(Tax $tax)
    {
        $this->taxRepository->delete($tax);
    }
}