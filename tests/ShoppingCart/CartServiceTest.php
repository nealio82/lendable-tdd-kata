<?php

declare(strict_types=1);

namespace Tests\ShoppingCart;

use Acme\ShoppingCart\CartId;
use Acme\ShoppingCart\CartRepository;
use Acme\ShoppingCart\CartService;
use Acme\ShoppingCart\Product;
use Acme\ShoppingCart\ShoppingCart;
use PHPUnit\Framework\TestCase;

final class CartServiceTest extends TestCase
{
    public function test_a_cart_can_be_stored(): void
    {
        $repository = new CartRepository();

        $cartService = new CartService($repository);

        $cart = new ShoppingCart(CartId::generate());

        $cartService->store($cart);

        $this->assertSame($cart, $repository->getCart($cart->id()));
    }

    public function test_a_cart_with_products_can_be_stored(): void
    {
        $repository = new CartRepository();

        $cartService = new CartService($repository);

        $product = Product::safe('Macbook Pro M1X', 500);

        $cart = new ShoppingCart(CartId::generate());
        $cart->addProduct($product);

        $cartService->store($cart);

        $this->assertEquals([$product], $repository->getCart($cart->id())->getProducts());
    }


    public function test_a_cart_can_be_updated(): void
    {
        $repository = new CartRepository();

        $cartService = new CartService($repository);

        $cart = new ShoppingCart(CartId::generate());

        $cartService->store($cart);

        $this->assertEquals([], $repository->getCart($cart->id())->getProducts());

        $product = Product::safe('Macbook Pro M1X', 500);
        $cart->addProduct($product);

        $cartService->store($cart);

        $this->assertEquals([$product], $repository->getCart($cart->id())->getProducts());
    }

    // @todo retrieve cart from service
    // @todo test exception when cart not found
}