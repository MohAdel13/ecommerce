<?php

namespace Modules\Promotion\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginationRequest;
use App\Http\Resources\PaginationCollection;
use App\Traits\ApiResponseTrait;
use App\Utils\DTO;
use Illuminate\Http\Request;
use Modules\Promotion\Http\Requests\CreateOfferRequest;
use Modules\Promotion\Http\Requests\UpdateOfferRequest;
use Modules\Promotion\Models\Offer;
use Modules\Promotion\Services\OfferService;
use Modules\Promotion\Transformers\OfferResource;

class OfferController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private OfferService $offerService
    ) {
    }

    public function index(PaginationRequest $request)
    {
        $offers = $this->offerService->index($request->filled('page'));

        $data = $request->filled('page') ? new PaginationCollection($offers, 'offers', OfferResource::class) :
            OfferResource::collection($offers);

        return $this->success(
            data: $data
        );
    }

    public function create(CreateOfferRequest $request)
    {
        $dto = DTO::fromRequest($request, [
            'code',
            'discount_value',
            'starts_at',
            'ends_at',
            'is_active',
        ]);

        $offer = $this->offerService->create($dto);

        return $this->success(
            message: __('message.offer_create_success'),
            data: new OfferResource($offer)
        );
    }

    public function update(UpdateOfferRequest $request, Offer $offer)
    {
        $dto = DTO::fromRequest($request, [
            'code',
            'discount_value',
            'starts_at',
            'ends_at',
            'is_active',
        ]);

        $offer = $this->offerService->update($offer, $dto);

        return $this->success(
            message: __('message.offer_update_success'),
            data: new OfferResource($offer)
        );
    }

    public function delete(Offer $offer)
    {
        $this->offerService->delete($offer);

        return $this->success(
            message: __('message.offer_delete_success')
        );
    }
}