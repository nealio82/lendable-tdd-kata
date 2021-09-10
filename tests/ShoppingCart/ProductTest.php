<?php

declare(strict_types=1);

namespace Tests\ShoppingCart;

use Acme\ShoppingCart\NormalProduct;
use PHPUnit\Framework\TestCase;

final class ProductTest extends TestCase
{
    public function test_two_instances_are_equal(): void
    {
        $product1 = new NormalProduct('Macbook Pro', 200);
        $product2 = new NormalProduct('Macbook Pro', 200);

        $this->assertTrue($product1->equals($product2));
    }

    public function test_two_instances_are_not_equal(): void
    {
        $product1 = new NormalProduct('Macbook Pro', 200);
        $product2 = new NormalProduct('Thinkpad', 200);

        $this->assertFalse($product1->equals($product2));
    }

    public function test_a_product_has_a_price(): void
    {
        $product = new NormalProduct('XPS', 200);
        $product2 = new NormalProduct('XPS', 500);

        $this->assertSame(200, $product->getPrice());
        $this->assertSame(500, $product2->getPrice());
    }
}