<?php
namespace Modules\Promotion\Services;

use App\Utils\DTO;
use Modules\Promotion\Repositories\OfferRepository;
use Modules\Promotion\Models\Offer;

class OfferService
{
    public function __construct(
        private OfferRepository $offerRepository
    ) {
    }

    public function index(bool $page, ?int $product_id)
    {
        return $page
            ? $this->offerRepository->getPaginatedOffers($product_id)
            : $this->offerRepository->getAllOffers($product_id);
    }

    public function create(DTO $dto)
    {
        return $this->offerRepository->create($dto->getData());
    }

    public function update(Offer $offer, DTO $dto)
    {
        return $this->offerRepository->update($offer, $dto->getData());
    }

    public function delete(Offer $offer): void
    {
        $this->offerRepository->delete($offer);
    }
}