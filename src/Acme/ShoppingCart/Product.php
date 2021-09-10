<?php

declare(strict_types=1);

namespace Acme\ShoppingCart;

final class Product
{
    private string $name;
    private int $basePrice;
    private bool $isDangerous;

    private function __construct(string $productName, int $basePrice, bool $isDangerous = false)
    {
        $this->name = $productName;
        $this->basePrice = $basePrice;
        $this->isDangerous = $isDangerous;
    }

    public static function dangerous(string $productName, int $basePrice): self
    {
        return new self($productName, $basePrice, true);
    }

    public static function safe(string $productName, int $basePrice): self
    {
        return new self($productName, $basePrice, false);
    }

    public function equals(Product $other): bool
    {
        if ($this->isDangerous !== $other->isDangerous) {
            return false;
        }

        return $this->name === $other->name;
    }

    public function getPrice(): int
    {
        return $this->basePrice;
    }

    public function isDangerous(): bool
    {
        return $this->isDangerous;
    }
}