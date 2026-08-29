<?php

namespace Modules\Banner\Observers;

use App\Observers\CacheObserver;
use Modules\Banner\Models\Banner;

class BannerObserver extends CacheObserver
{
    public function __construct()
    {
        $this->keys = ['home_banners'];
    }
}