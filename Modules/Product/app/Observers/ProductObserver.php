<?php

namespace Modules\Product\Observers;

use App\Observers\CacheObserver;
use Modules\Product\Models\Product;

class ProductObserver extends CacheObserver
{
    public function __construct()
    {
        $this->keys = ['home_best_selling', 'home_best_offers'];
    }
}
