<?php

declare(strict_types=1);

namespace Tests\ShoppingCart;

use Acme\ShoppingCart\Product;
use PHPUnit\Framework\TestCase;

final class ProductTest extends TestCase
{
    public function test_two_instances_are_equal(): void
    {
        $product1 = new Product('Macbook Pro', 200);
        $product2 = new Product('Macbook Pro', 200);

        $this->assertTrue($product1->equals($product2));
    }

    public function test_two_instances_are_not_equal(): void
    {
        $product1 = new Product('Macbook Pro', 200);
        $product2 = new Product('Thinkpad', 200);

        $this->assertFalse($product1->equals($product2));
    }

    public function test_a_product_has_a_price(): void
    {
        $product = new Product('XPS', 200);
        $product2 = new Product('XPS', 500);

        $this->assertSame(200, $product->getPrice());
        $this->assertSame(500, $product2->getPrice());
    }
}