<?php

declare(strict_types=1);


namespace Acme\ShoppingCart;

interface Product
{
    public function equals(Product $other): bool;

    public function isDangerous(): bool;
}