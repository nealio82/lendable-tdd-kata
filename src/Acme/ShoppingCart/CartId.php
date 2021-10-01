<?php

declare(strict_types=1);

namespace Acme\ShoppingCart;

final class CartId
{
    private int $id;

    private function __construct(int $id)
    {

        $this->id = $id;
    }

    public static function generate(): self
    {
        return new self(rand(1, 10000));
    }

    public function toInt(): int
    {
        return $this->id;
    }
}