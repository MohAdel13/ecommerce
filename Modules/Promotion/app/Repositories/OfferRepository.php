<?php
namespace Modules\Promotion\Repositories;

use Modules\Promotion\Models\Offer;

class OfferRepository
{
    public function getAllOffers(?int $product_id)
    {
        return $this->queryOffers($product_id)->get();
    }

    public function getPaginatedOffers(?int $product_id)
    {
        return $this->queryOffers($product_id)->paginate(15, ['*'], 'page');
    }

    public function queryOffers(?int $product_id)
    {
        return Offer::latest()
            ->when(
                $product_id,
                fn($q) => $q->whereHas('products', fn($q) => $q->where('products.id', $product_id))
            );
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