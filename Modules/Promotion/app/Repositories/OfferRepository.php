<?php
namespace Modules\Promotion\App\Repositories;

use Modules\Promotion\Models\Offer;

class OfferRepository
{
    public function getAllOffers()
    {
        return $this->queryOffers()->get();
    }

    public function getPaginatedOffers()
    {
        return $this->queryOffers()->paginate(15, ['*'], 'page');
    }

    public function queryOffers()
    {
        return Offer::latest();
    }

    public function create(array $data)
    {
        return Offer::create($data);
    }

    public function update(Offer $offer, array $data)
    {
        $offer->update($data);

        return $offer->refresh();
    }

    public function delete(Offer $offer): void
    {
        $offer->delete();
    }
}