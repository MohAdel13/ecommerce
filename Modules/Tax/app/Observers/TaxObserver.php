<?php

namespace Modules\Tax\Observers;

use App\Observers\CacheObserver;
use Modules\Tax\Models\Tax;

class TaxObserver extends CacheObserver
{
    public function __construct()
    {
        $this->keys = ['home_best_selling', 'home_best_offers'];
    }
}
