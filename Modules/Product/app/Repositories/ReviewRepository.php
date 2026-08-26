<?php

namespace Modules\Product\Repositories;

use Modules\Product\Models\Review;

class ReviewRepository
{
    public function findUserReview(int $productId, int $userId)
    {
        return Review::where('product_id', $productId)
            ->where('user_id', $userId)
            ->first();
    }

    public function create(array $data)
    {
        return Review::create($data);
    }

    public function update(Review $review, array $data)
    {
        $review->update($data);

        return $review->refresh();
    }
}