<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class CacheObserver
{
    protected $keys = [];

    public function saved(): void
    {
        $this->forgetKeys();
    }

    public function updated(): void
    {
        $this->forgetKeys();
    }

    public function deleted(): void
    {
        $this->forgetKeys();
    }

    private function forgetKeys(): void
    {
        foreach ($this->keys as $key) {
            Cache::forget($key);
        }
    }
}