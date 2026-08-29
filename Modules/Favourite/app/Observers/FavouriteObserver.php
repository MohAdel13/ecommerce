<?php

namespace Modules\Favourite\Observers;

use App\Observers\CacheObserver;
use Modules\Favourite\Models\Favourite;

class FavouriteObserver extends CacheObserver
{
    public function __construct()
    {
        $this->keys = ['home_best_selling', 'home_best_offers'];
    }
}