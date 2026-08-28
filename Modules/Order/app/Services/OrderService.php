<?php

namespace Modules\Order\Services;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Exceptions\BusinessException;
use App\Models\User;
use App\Utils\DTO;
use Exception;
use Illuminate\Support\Facades\DB;
use Modules\Cart\Models\Cart;
use Modules\Cart\Repositories\CartRepository;
use Modules\Cart\Services\CartService;
use Modules\Notification\Services\NotificationService;
use Modules\Order\Models\Order;
use Modules\Order\Repositories\OrderItemRepository;
use Modules\Order\Repositories\OrderRepository;
use Modules\Payment\Repositories\PaymentRepository;
use Modules\Product\Repositories\ProductVariantRepository;
use Modules\Promotion\Services\CouponService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrderService
{
    public function __construct(
        private OrderRepository $orderRepository,
        private CouponService $couponService,
        private CartRepository $cartRepository,
        private CartService $cartService,
        private ProductVariantRepository $productVariantRepository,
        private OrderItemRepository $orderItemRepository,
        private PaymentRepository $paymentRepository,
        private NotificationService $notificationService
    ) {
    }

    public function index(DTO $dto)
    {
        return $dto->page ? $this->orderRepository->getPaginatedOrders($dto) :
            $this->orderRepository->getAllOrders($dto);
    }

    public function create(DTO $dto)
    {
        $coupon = null;
        if ($dto->coupon_code) {
            $coupon = $this->couponService->validateCoupon($dto->coupon_code, $dto->user);
        }

        $cart = $this->cartRepository->getOrCreateCart($dto->user->id);
        if ($cart->is_empty) {
            throw new BusinessException(message: __('message.cart_is_empty'), code: 400, errors: [__('message.cart_is_empty')]);
        }

        $dto->append(['status' => OrderStatus::Pending, 'user_id' => $dto->user->id]);
        return DB::transaction(function () use ($dto, $cart, $coupon) {
            $variantIds = $cart->cartItems
                ->pluck('product_variant_id')
                ->unique()
                ->values()
                ->all();

            $variants = $this->productVariantRepository->lockProductVariants($variantIds);

            $order = $this->orderRepository->createOrder($dto->getData());

            $amounts = $this->cartService->calculate($cart, $dto->coupon_code);

            $subtotal = $amounts['subtotal'];
            $discount = $amounts['discount'];
            $coupon_amount = $amounts['coupon_discount'];
            $tax = $amounts['tax_amount'];
            $total = $amounts['total'];

            $this->createOrderItems($order->id, $cart, $variants);

            $this->orderRepository->updateOrder($order, ['subtotal' => $subtotal, 'discount' => $discount, 'coupon_amount' => $coupon_amount, 'tax' => $tax, 'total_amount' => $total]);

            $payment = $this->createPayment($order, $dto->payment_method);

            if ($coupon) {
                $this->couponService->useCoupon($dto->user, $coupon->id);
            }

            $this->cartService->removeAll($dto->user);

            $this->notificationService->sendNotification(
                new DTO([
                    'user_id' => $dto->user->id,
                    'fcm_token' => $dto->user->fcm_token,
                    'title' => __('notifications.order_created.title'),
                    'body' => __('notifications.order_created.body', [
                        'order' => $order->transaction_id,
                    ]),
                    'notifiable_id' => $order->id,
                    'notifiable_type' => 'order',
                ])
            );
            return $payment;
        });
    }

    public function update(Order $order, DTO $dto)
    {
        $return = $this->orderRepository->updateOrder($order, $dto->getData());

        $status = $dto->getData()['status'] ?? null;

        $notificationKey = match ($status) {
            OrderStatus::Processing->value => 'notifications.order_confirmed',
            OrderStatus::Shipped->value => 'notifications.order_shipped',
            OrderStatus::Delivered->value => 'notifications.order_delivered',
            OrderStatus::Cancelled->value => 'notifications.order_cancelled',
            default => null,
        };

        if ($notificationKey) {
            $this->notificationService->sendNotification(
                new DTO([
                    'user_id' => $order->user_id,
                    'fcm_token' => $order->user->fcm_token,
                    'title' => __("$notificationKey.title"),
                    'body' => __("$notificationKey.body", [
                        'order' => $order->transaction_id,
                    ]),
                    'notifiable_id' => $order->id,
                    'notifiable_type' => 'order',
                ])
            );
        }

        return $return;
    }

    public function delete(Order $order)
    {
        $this->orderRepository->deleteOrder($order);
    }

    public function cancel(Order $order, User $user)
    {
        if ($user->id !== $order->user_id) {
            throw new NotFoundHttpException();
        } elseif (in_array($order->status, [OrderStatus::Shipped, OrderStatus::Delivered])) {
            throw new BusinessException(message: __('message.cannot_cancel_order_after_shipping'), code: 400, errors: [__('message.cannot_cancel_order_after_shipping')]);
        }

        $this->paymentRepository->update($order->payment, ['status' => PaymentStatus::Cancelled]);

        $return = $this->orderRepository->updateOrder($order, ['status' => OrderStatus::Cancelled]);

        $this->notificationService->sendNotification(
            new DTO([
                'user_id' => $user->id,
                'fcm_token' => $user->fcm_token,
                'title' => __('notifications.order_cancelled.title'),
                'body' => __('notifications.order_cancelled.body', [
                    'order' => $order->transaction_id,
                ]),
                'notifiable_id' => $order->id,
                'notifiable_type' => 'order',
            ])
        );

        return $return;
    }

    public function statuses()
    {
        return $this->orderRepository->getStatuses();
    }

    private function createOrderItems(int $order_id, Cart $cart, $variants)
    {
        $orderItems = $cart->cartItems;
        foreach ($orderItems as $item) {
            $data = [];
            $variant = $variants[$item->product_variant_id];
            if ($variant->stock < $item->quantity) {
                throw new BusinessException(message: __('message.insufficient_stock'), code: 400, errors: [__('message.insufficient_stock')]);
            }

            $data['order_id'] = $order_id;
            $data['product_variant_id'] = $variant->id;
            $data['product_variant_sku'] = $variant->sku;
            $data['quantity'] = $item->quantity;

            $data['product_name_en'] = $variant->product->name_en;
            $data['product_name_ar'] = $variant->product->name_ar;
            $data['unit_price'] = $variant->price;
            $data['discount'] = $variant->price - $variant->priceAfterDiscount();

            $data['subtotal'] = $variant->priceAfterDiscount() * $data['quantity'];

            $attributes = null;
            if ($variant->attributeValues->count()) {
                $attributes = $variant->attributeValues->mapWithKeys(function ($value) {
                    return [
                        $value->attribute->{'name_' . app()->getLocale()} => $value->{'value_' . app()->getLocale()},
                    ];
                })->toArray();
            }

            $data['selected_attributes'] = $attributes;

            $this->orderItemRepository->create($data);

            $variant->decrement('stock', $item->quantity);
        }
    }

    private function createPayment(Order $order, string $paymentMethod)
    {
        $data = [
            'order_id' => $order->id,
            'transaction_id' => 'ORD_' . str_pad($order->id, 6, '0', STR_PAD_LEFT),
            'payment_method' => $paymentMethod,
            'status' => $paymentMethod === PaymentMethod::COD->value ? PaymentStatus::Pending : PaymentStatus::Paid,
            'amount' => $order->total_amount,
            'paid_at' => $paymentMethod === PaymentMethod::COD->value ? null : now(),
        ];

        return $this->paymentRepository->create($data);
    }
}