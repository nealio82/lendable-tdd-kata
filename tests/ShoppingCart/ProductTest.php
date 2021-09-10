<?php

declare(strict_types=1);

namespace Tests\ShoppingCart;

use Acme\ShoppingCart\Product;
use PHPUnit\Framework\TestCase;

final class ProductTest extends TestCase
{
    public function test_two_instances_are_equal(): void
    {
        $product1 = Product::safe('Macbook Pro', 200);
        $product2 = Product::safe('Macbook Pro', 200);

        $this->assertTrue($product1->equals($product2));
    }

    public function test_two_instances_are_not_equal(): void
    {
        $product1 = Product::safe('Macbook Pro', 200);
        $product2 = Product::safe('Thinkpad', 200);

        $this->assertFalse($product1->equals($product2));
    }

    public function test_a_product_has_a_price(): void
    {
        $product = Product::safe('XPS', 200);
        $product2 = Product::safe('XPS', 500);

        $this->assertSame(200, $product->getPrice());
        $this->assertSame(500, $product2->getPrice());
    }

    public function test_a_non_dangerous_product_is_created(): void
    {
        $product = Product::safe('Mountain Rescue Dog', 800);

        $this->assertFalse($product->isDangerous());
    }

    public function test_a_dangerous_product_is_created(): void
    {
        $product = Product::dangerous('Army Dog', 500);

        $this->assertTrue($product->isDangerous());
    }

    public function test_a_safe_product_is_not_equal_to_a_dangerous_product_with_the_same_name(): void
    {
        $safeProduct = Product::safe('Torch', 150);
        $dangerousProduct = Product::dangerous('Torch', 150);

        $this->assertFalse($safeProduct->equals($dangerousProduct));
    }
}