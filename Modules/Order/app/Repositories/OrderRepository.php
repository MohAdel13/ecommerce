<?php

namespace Modules\Order\Repositories;

use App\Enums\OrderStatus;
use App\Utils\DTO;
use Modules\Order\Models\Order;

class OrderRepository
{
    public function getAllOrders(DTO $dto)
    {
        return $this->queryOrders($dto)->get();
    }

    public function getPaginatedOrders(DTO $dto)
    {
        return $this->queryOrders($dto)->paginate(15, ['*'], 'page');
    }

    private function queryOrders(DTO $dto)
    {
        return Order::query()->with(['user', 'orderItems', 'address'])
            ->when(
                $dto->status,
                fn($query) => $query->where('status', $dto->status)
            )
            ->when(
                $dto->user_id,
                fn($q) => $q->where('user_id', $dto->user_id)
            )->latest();
    }

    public function createOrder(array $data)
    {
        return Order::create($data)->load(['user', 'orderItems', 'address']);
    }

    public function updateOrder(Order $order, array $data)
    {
        $order->update($data);

        return $order->fresh(['user', 'orderItems', 'address']);
    }

    public function deleteOrder(Order $order)
    {
        $order->delete();
    }

    public function getStatuses(): array
    {
        return OrderStatus::cases();
    }
}