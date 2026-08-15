<?php
namespace Modules\Favourite\Repositories;

use App\Models\User;

class FavouriteRepository
{
    public function findUserFavourite(User $user, int $product_id)
    {
        return $user->favourites()->where('product_id', $product_id)->first();
    }

    public function addToFavourite(User $user, int $product_id)
    {
        $user->favourites()->create([
            'user_id' => $user->id,
            'product_id' => $product_id,
        ]);
    }

    public function removeFromFavourite(User $user, int $product_id)
    {
        $user->favourites()->where('product_id', $product_id)->first()?->delete();
    }
}