<?php

namespace Modules\Order\Observers;

use App\Observers\CacheObserver;
use Modules\Order\Models\Order;

class OrderObserver extends CacheObserver
{
    public function __construct()
    {
        $this->keys = ['home_best_selling', 'home_best_offers'];
    }
}
