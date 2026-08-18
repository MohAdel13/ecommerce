<?php
namespace Modules\Cart\Services;

use App\Enums\PaymentMethod;
use App\Exceptions\BusinessException;
use App\Models\User;
use App\Utils\DTO;
use Modules\Cart\Models\Cart;
use Modules\Cart\Repositories\CartRepository;
use Modules\Product\Repositories\ProductVariantRepository;
use Modules\Promotion\Repositories\CouponRepository;
use Modules\Promotion\Services\CouponService;

class CartService
{
    public function __construct(
        private CartRepository $cartRepository,
        private ProductVariantRepository $productVariantRepository,
        private CouponRepository $couponRepository,
        private CouponService $couponService
    ) {
    }

    public function getUserCart(User $user)
    {
        return $this->cartRepository->getOrCreateCart($user->id)->load('cartItems.variant.product.tax');
    }

    public function add(DTO $dto)
    {
        $quantity = $dto->quantity ?? 1;

        $variant = $this->productVariantRepository->getBySku($dto->sku);

        $cart = $this->cartRepository->getOrCreateCart($dto->user->id);

        $cart_item = $this->cartRepository->findItem($cart, $variant->id);

        if ($cart_item) {
            $this->cartRepository->incrementItemQuantity($cart_item, $quantity);

        } else {

            $this->cartRepository->createItem([
                'cart_id' => $cart->id,
                'product_variant_id' => $variant->id,
                'quantity' => $quantity
            ]);
        }
    }

    public function removeAll(User $user)
    {
        $cart = $this->cartRepository->getOrCreateCart($user->id);

        $this->cartRepository->clearItems($cart);
    }

    public function updateItem(DTO $dto): void
    {
        $cart = $this->cartRepository->getOrCreateCart($dto->user->id);

        $variant = $this->productVariantRepository->getBySku($dto->sku);

        $item = $this->cartRepository->findItem($cart, $variant->id);

        if (!$item) {
            throw new BusinessException(message: __('message.sku_not_found'), code: 404, errors: [__('message.sku_not_found')]);
        }

        $this->cartRepository->updateItemQuantity($item, $dto->quantity);
    }

    public function removeItem(DTO $dto): void
    {
        $cart = $this->cartRepository->getOrCreateCart($dto->user->id);

        $variant = $this->productVariantRepository->getBySku($dto->sku);

        $item = $this->cartRepository->findItem($cart, $variant->id);

        if (!$item) {
            throw new BusinessException(message: __('message.sku_not_found'), code: 404, errors: [__('message.sku_not_found')]);
        }

        $this->cartRepository->deleteItem($item);
    }

    public function calculate(Cart $cart, ?string $coupon_code): array
    {
        $coupon = null;
        if ($coupon_code) {
            $coupon = $this->couponRepository->findByCode($coupon_code);
        }

        $subtotal = $cart->subtotal;

        $subtotalAfterProductDiscount = $cart->total_after_discount;

        $couponDiscount = 0;

        if ($coupon) {
            $couponDiscount = $this->couponService->calculateCouponDiscount(
                $coupon,
                $subtotalAfterProductDiscount
            );

        }

        $subtotalAfterDiscount = $subtotalAfterProductDiscount - $couponDiscount;

        $taxAmount = $this->calculateTax(
            $cart,
            $couponDiscount,
            $subtotalAfterProductDiscount
        );

        // return [
        //     'subtotal' => $subtotal,
        //     'discount' => $subtotal - $subtotalAfterProductDiscount,
        //     'coupon_discount' => $couponDiscount,
        //     'subtotal_after_discount' => $subtotalAfterDiscount,
        //     'tax_amount' => $tax,
        //     'total' => $subtotalAfterDiscount + $tax,
        // ];

        return [
            'subtotal' => $subtotal,
            'discount' => $subtotal - $subtotalAfterProductDiscount,
            'coupon_discount' => $couponDiscount,
            'subtotal_after_discount' => $subtotalAfterDiscount,
            'tax_amount' => $taxAmount,
            'total' => $subtotalAfterDiscount + $taxAmount,
        ];
    }

    public function getPaymentMethods(): array
    {
        return PaymentMethod::cases();
    }

    private function calculateTax(Cart $cart, float $couponDiscount, float $subtotalAfterProductDiscount)
    {
        if ($subtotalAfterProductDiscount <= 0) {
            return 0;
        }

        return $cart->cartItems->sum(function ($item) use ($couponDiscount, $subtotalAfterProductDiscount) {

            $itemAmount = $item->quantity * $item->variant->priceAfterDiscount();

            $itemCouponDiscount = ($itemAmount / $subtotalAfterProductDiscount) * $couponDiscount;

            $taxableAmount = $itemAmount - $itemCouponDiscount;

            $taxRate = $item->variant->product->tax?->rate ?? 0;

            return $taxableAmount * ($taxRate / 100);
        });
    }
}