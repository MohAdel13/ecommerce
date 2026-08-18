<?php

namespace Modules\Cart\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\EnumResource;
use App\Traits\ApiResponseTrait;
use App\Utils\DTO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Cart\Http\Requests\AddToCartRequest;
use Modules\Cart\Http\Requests\CheckoutRequest;
use Modules\Cart\Http\Requests\RemoveFromCartRequest;
use Modules\Cart\Services\CartService;
use Modules\Cart\Transformers\CartResource;

class CartController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private CartService $cartService)
    {
    }

    public function index(CheckoutRequest $request)
    {
        $cart = $this->cartService->getUserCart(Auth::user());

        $summary = $this->cartService->calculate($cart, $request->coupon_code);

        $payment_methods = $this->cartService->getPaymentMethods();

        return $this->success(
            data: [
                'payment_methods' => EnumResource::collection($payment_methods),
                'cart' => new CartResource($cart, $summary)
            ]
        );
    }

    public function add(AddToCartRequest $request)
    {
        $dto = DTO::fromRequest($request, ['sku', 'quantity'], Auth::user());

        $this->cartService->add($dto);

        return $this->success(
            message: __('message.added_to_cart')
        );
    }

    public function removeAll()
    {
        $this->cartService->removeAll(Auth::user());

        return $this->success(
            message: __('message.removed_from_cart')
        );
    }

    public function update(AddToCartRequest $request)
    {
        $dto = DTO::fromRequest($request, ['sku', 'quantity'], $request->user());

        $this->cartService->updateItem($dto);

        return $this->success(message: __('message.cart_updated'));
    }

    public function remove(RemoveFromCartRequest $request)
    {
        $dto = DTO::fromRequest($request, ['sku'], Auth::user());

        $this->cartService->removeItem($dto);

        return $this->success(
            message: __('message.removed_from_cart')
        );
    }
}