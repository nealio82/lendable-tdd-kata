<?php

declare(strict_types=1);

namespace Tests\ShoppingCart;

use Acme\ShoppingCart\Product;
use Acme\ShoppingCart\ProductDoesNotExistInCart;
use Acme\ShoppingCart\ShoppingCart;
use PHPUnit\Framework\TestCase;

final class ShoppingCartTest extends TestCase
{
    public function test_a_product_can_be_added_to_a_cart(): void
    {
        $cart = new ShoppingCart();

        $product = new Product('Macbook', 100);

        $cart->addProduct($product);

        $this->assertSame([$product], $cart->getProducts());
    }

    public function test_multiple_products_can_be_added(): void
    {
        $cart = new ShoppingCart();

        $product = new Product('Macbook', 100);
        $product2 = new Product('Thinkpad', 100);

        $cart->addProduct($product);
        $cart->addProduct($product2);

        $this->assertSame([$product, $product2], $cart->getProducts());
    }

    public function test_a_product_can_be_removed(): void
    {
        $cart = new ShoppingCart();

        $product = new Product('Macbook', 100);
        $product2 = new Product('Thinkpad', 100);

        $cart->addProduct($product);
        $cart->addProduct($product2);

        $this->assertSame([$product, $product2], $cart->getProducts());

        $cart->removeOne(new Product('Thinkpad', 100));

        $this->assertSame([$product], $cart->getProducts());
    }

    public function test_a_product_cannot_be_removed_if_it_has_not_been_added(): void
    {
        $cart = new ShoppingCart();

        $product = new Product('Macbook', 100);

        $this->expectException(ProductDoesNotExistInCart::class);
        $cart->removeOne($product);
    }

    public function test_all_products_of_a_type_can_be_removed(): void
    {
        $cart = new ShoppingCart();

        $product = new Product('Macbook', 100);
        $product2 = new Product('Macbook', 100);

        $cart->addProduct($product);
        $cart->addProduct($product2);

        $cart->removeAll(new Product('Macbook', 100));
        $this->assertEmpty($cart->getProducts());
    }


    public function test_a_quantity_of_a_product_can_be_added(): void
    {
        $cart = new ShoppingCart();

        $product = new Product('Macbook', 100);

        $cart->addProduct($product, 5);
        $this->assertSame(5, $cart->getQuantityFor($product));

        $cart->addProduct($product);
        $this->assertSame(6, $cart->getQuantityFor($product));
    }

    public function test_a_gross_value_is_calculated(): void
    {
        $cart = new ShoppingCart();

        $product = new Product('Macbook', 300);

        $cart->addProduct($product, 5);
        $this->assertSame(1500, $cart->getGrossValue());

        $cart->addProduct($product);
        $this->assertSame(1800, $cart->getGrossValue());
    }
}