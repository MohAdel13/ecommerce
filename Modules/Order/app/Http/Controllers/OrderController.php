<?php

namespace Modules\Order\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\EnumResource;
use App\Http\Resources\PaginationCollection;
use App\Traits\ApiResponseTrait;
use App\Utils\DTO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Order\Http\Requests\CreateOrderRequest;
use Modules\Order\Http\Requests\GetOrdersRequest;
use Modules\Order\Http\Requests\UpdateOrderRequest;
use Modules\Order\Models\Order;
use Modules\Order\Services\OrderService;
use Modules\Order\Transformers\OrderResource;
use Modules\Payment\Transformers\PaymentResource;

class OrderController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private OrderService $orderService)
    {
    }

    public function index(GetOrdersRequest $request)
    {
        $dto = DTO::fromRequest($request, ['user_id', 'status']);
        $dto->append(['page' => $request->filled('page')]);

        $orders = $this->orderService->index($dto);
        $data = $request->filled('page') ? new PaginationCollection($orders, 'orders', OrderResource::class) :
            OrderResource::collection($orders);

        return $this->success(
            data: $data
        );
    }

    public function myOrders(GetOrdersRequest $request)
    {
        $dto = DTO::fromRequest($request, ['status']);
        $dto->append(['page' => $request->filled('page'), 'user_id' => Auth::user()->id]);

        $orders = $this->orderService->index($dto);
        $data = $request->filled('page') ? new PaginationCollection($orders, 'orders', OrderResource::class) :
            OrderResource::collection($orders);

        return $this->success(
            data: $data
        );
    }

    public function show(Order $order)
    {
        return $this->success(
            data: new OrderResource($order->load(['user', 'address']))
        );
    }

    public function create(CreateOrderRequest $request)
    {
        $dto = DTO::fromRequest($request, ['address_id', 'coupon_code', 'payment_method'], Auth::user());

        $payment = $this->orderService->create($dto);

        $data = new PaymentResource($payment);

        return $this->success(message: __('message.order_create_succeeded'), data: $data);
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $dto = DTO::fromRequest($request, ['status']);
        $order = new OrderResource($this->orderService->update($order, $dto));

        return $this->success(
            message: __('message.order_update_succeeded'),
            data: $order
        );
    }

    public function delete(Order $order)
    {
        $this->orderService->delete($order);

        return $this->success(
            message: __('message.order_delete_succeeded')
        );
    }

    public function statuses()
    {
        return $this->success(
            data: EnumResource::collection($this->orderService->statuses())
        );
    }

    public function cancel(Order $order)
    {
        $order = new OrderResource($this->orderService->cancel($order, Auth::user()));

        return $this->success(
            message: __('message.order_update_succeeded'),
            data: $order
        );
    }
}