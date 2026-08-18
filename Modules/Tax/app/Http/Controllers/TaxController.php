<?php

namespace Modules\Tax\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginationRequest;
use App\Http\Resources\PaginationCollection;
use App\Traits\ApiResponseTrait;
use App\Utils\DTO;
use Illuminate\Http\Request;
use Modules\Tax\Http\Requests\CreateTaxRequest;
use Modules\Tax\Http\Requests\UpdateTaxRequest;
use Modules\Tax\Models\Tax;
use Modules\Tax\Services\TaxService;
use Modules\Tax\Transformers\TaxResource;

class TaxController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private TaxService $taxService
    ) {
    }

    public function show(Tax $tax)
    {
        $data = new TaxResource($tax);

        return $this->success(
            data: $data
        );
    }

    public function index(PaginationRequest $request)
    {
        $taxes = $this->taxService->index($request->filled('page'));

        $data = $request->filled('page') ? new PaginationCollection($taxes, 'taxes', TaxResource::class) :
            TaxResource::collection($taxes);

        return $this->success(
            data: $data
        );
    }

    public function create(CreateTaxRequest $request)
    {
        $dto = DTO::FromRequest($request, ['name_en', 'name_ar', 'rate', 'is_active']);

        $tax = $this->taxService->create($dto);

        $data = new TaxResource($tax);

        return $this->success(
            message: __('message.tax_created'),
            data: $data
        );
    }

    public function update(UpdateTaxRequest $request, Tax $tax)
    {
        $dto = DTO::FromRequest($request, ['name_en', 'name_ar', 'rate', 'is_active']);

        $tax = $this->taxService->update($tax, $dto);

        $data = new TaxResource($tax);

        return $this->success(
            message: __('message.tax_updated'),
            data: $data
        );
    }

    public function delete(Tax $tax)
    {
        $this->taxService->delete($tax);

        return $this->success(
            message: __('message.tax_deleted')
        );
    }
}