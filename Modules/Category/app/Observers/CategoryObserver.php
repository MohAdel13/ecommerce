<?php

namespace Modules\Category\Observers;

use App\Observers\CacheObserver;
use Modules\Category\Models\Category;

class CategoryObserver extends CacheObserver
{
    public function __construct()
    {
        $this->keys = ['home_categories'];
    }
}