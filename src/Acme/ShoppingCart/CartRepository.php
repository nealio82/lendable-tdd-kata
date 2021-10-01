<?php

declare(strict_types=1);

namespace Acme\ShoppingCart;

final class CartRepository
{
    private array $carts = [];

    public function getCart(CartId $id): ShoppingCart
    {
        return $this->carts[$id->toInt()];
    }

    public function save(ShoppingCart $cart): void
    {
        $this->carts[$cart->id()->toInt()] = $cart;
    }
}