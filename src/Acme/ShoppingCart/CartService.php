<?php

declare(strict_types=1);

namespace Acme\ShoppingCart;

final class CartService
{
    private CartRepository $repository;

    public function __construct(CartRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(ShoppingCart $cart): void
    {
        $this->repository->save($cart);
    }
}