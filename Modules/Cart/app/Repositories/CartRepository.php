<?php
namespace Modules\Cart\Repositories;

use Modules\Cart\Models\Cart;
use Modules\Cart\Models\CartItem;

class CartRepository
{
    public function getOrCreateCart(int $userId): Cart
    {
        return Cart::firstOrCreate(
            ['user_id' => $userId],
            []
        );
    }

    public function findItem(Cart $cart, int $variantId)
    {
        return $cart->cartItems()->where('product_variant_id', $variantId)->first();
    }

    public function createItem(array $data): CartItem
    {
        return CartItem::create($data);
    }

    public function incrementItemQuantity(CartItem $item, int $quantity): void
    {
        $item->update(['quantity' => $item->quantity + $quantity]);
    }

    public function updateItemQuantity(CartItem $item, int $quantity): void
    {
        $item->update(['quantity' => $quantity]);
    }

    public function clearItems(Cart $cart): void
    {
        $cart->cartItems()->delete();
    }

    public function deleteItem(CartItem $item): void
    {
        $item->delete();
    }

    public function getQuantityForUser(int $userId): int
    {
        $cart = $this->getOrCreateCart($userId);

        return (int) $cart->cartItems()->sum('quantity');
    }
}