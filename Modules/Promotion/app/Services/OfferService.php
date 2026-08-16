<?php
namespace Modules\Promotion\Services;

use App\Utils\DTO;
use Modules\Promotion\App\Repositories\OfferRepository;
use Modules\Promotion\Models\Offer;

class OfferService
{
    public function __construct(
        private OfferRepository $offerRepository
    ) {
    }

    public function index(bool $page)
    {
        return $page
            ? $this->offerRepository->getPaginatedOffers()
            : $this->offerRepository->getAllOffers();
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