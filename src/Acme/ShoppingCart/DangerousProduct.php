<?php

declare(strict_types=1);

namespace Acme\ShoppingCart;

final class DangerousProduct implements Product
{
    private string $name;
    private int $basePrice;

    public function __construct(string $productName, int $basePrice)
    {
        $this->name = $productName;
        $this->basePrice = $basePrice;
    }

    public function equals(Product $other): bool
    {
        return $this->name === $other->name;
    }

    public function isDangerous(): bool
    {
        return true;
    }
}