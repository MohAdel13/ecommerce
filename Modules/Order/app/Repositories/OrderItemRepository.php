<?php

namespace Modules\Order\Repositories;

use Modules\Order\Models\OrderItem;

class OrderItemRepository
{
    public function create(array $data)
    {
        OrderItem::create($data);
    }
}