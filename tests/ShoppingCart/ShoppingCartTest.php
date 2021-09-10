<?php

declare(strict_types=1);

namespace Tests\ShoppingCart;

use Acme\ShoppingCart\CartTooDangerousException;
use Acme\ShoppingCart\DangerousProduct;
use Acme\ShoppingCart\NormalProduct;
use Acme\ShoppingCart\ProductDoesNotExistInCart;
use Acme\ShoppingCart\ShoppingCart;
use PHPUnit\Framework\TestCase;

final class ShoppingCartTest extends TestCase
{
    public function test_a_product_can_be_added_to_a_cart(): void
    {
        $cart = new ShoppingCart();

        $product = new NormalProduct('Macbook', 100);

        $cart->addProduct($product);

        $this->assertSame([$product], $cart->getProducts());
    }

    public function test_multiple_products_can_be_added(): void
    {
        $cart = new ShoppingCart();

        $product = new NormalProduct('Macbook', 100);
        $product2 = new NormalProduct('Thinkpad', 100);

        $cart->addProduct($product);
        $cart->addProduct($product2);

        $this->assertSame([$product, $product2], $cart->getProducts());
    }

    public function test_a_product_can_be_removed(): void
    {
        $cart = new ShoppingCart();

        $product = new NormalProduct('Macbook', 100);
        $product2 = new NormalProduct('Thinkpad', 100);

        $cart->addProduct($product);
        $cart->addProduct($product2);

        $this->assertSame([$product, $product2], $cart->getProducts());

        $cart->removeOne(new NormalProduct('Thinkpad', 100));

        $this->assertSame([$product], $cart->getProducts());
    }

    public function test_a_product_cannot_be_removed_if_it_has_not_been_added(): void
    {
        $cart = new ShoppingCart();

        $product = new NormalProduct('Macbook', 100);

        $this->expectException(ProductDoesNotExistInCart::class);
        $cart->removeOne($product);
    }

    public function test_all_products_of_a_type_can_be_removed(): void
    {
        $cart = new ShoppingCart();

        $product = new NormalProduct('Macbook', 100);
        $product2 = new NormalProduct('Macbook', 100);

        $cart->addProduct($product);
        $cart->addProduct($product2);

        $cart->removeAll(new NormalProduct('Macbook', 100));
        $this->assertEmpty($cart->getProducts());
    }


    public function test_a_quantity_of_a_product_can_be_added(): void
    {
        $cart = new ShoppingCart();

        $product = new NormalProduct('Macbook', 100);

        $cart->addProduct($product, 5);
        $this->assertSame(5, $cart->getQuantityFor($product));

        $cart->addProduct($product);
        $this->assertSame(6, $cart->getQuantityFor($product));
    }

    public function test_a_gross_value_is_calculated(): void
    {
        $cart = new ShoppingCart();

        $product = new NormalProduct('Macbook', 300);

        $cart->addProduct($product, 5);
        $this->assertSame(1500, $cart->getGrossValue());

        $cart->addProduct($product);
        $this->assertSame(1800, $cart->getGrossValue());
    }

    public function test_no_more_than_3_dangerous_items_can_be_added_to_the_cart_at_once(): void
    {
        $cart = new ShoppingCart();

        $product = new DangerousProduct('Shark with lazer beams', 1500);

        $this->expectExceptionObject(CartTooDangerousException::sharksExceededLimit(4));
        $cart->addProduct($product, 4);
    }

    public function test_3_dangerous_items_can_be_added_to_the_cart(): void
    {
        $cart = new ShoppingCart();

        $product = new DangerousProduct('Shark with lazer beams', 1500);

        $cart->addProduct($product, 3);

        $this->assertCount(3, $cart->getProducts());
    }

    public function test_no_more_than_3_dangerous_items_can_be_added_to_the_cart(): void
    {
        $cart = new ShoppingCart();

        $product = new DangerousProduct('Shark with lazer beams', 1500);

        $cart->addProduct($product, 3);

        $this->expectExceptionObject(CartTooDangerousException::sharksExceededLimit(4));
        $cart->addProduct($product);
    }

    public function test_dangerous_items_can_be_replaced(): void
    {
        $cart = new ShoppingCart();

        $product = new DangerousProduct('Shark with lazer beams', 1500);
        $product2 = new DangerousProduct('Flamethrower', 200);

        $cart->addProduct($product, 3);

        $cart->removeAll($product);

        $cart->addProduct($product2, 3);

        $this->assertSame(3, $cart->getQuantityFor($product2));
    }

    // @todo: check product type in equality test
}