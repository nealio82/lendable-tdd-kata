<?php

declare(strict_types=1);

namespace Acme\ShoppingCart;

final class CartTooDangerousException extends \Exception
{
    public static function sharksExceededLimit(int $numberAdded): self
    {
        return new self(\sprintf('You added %s sharks but the limit is 3', $numberAdded));
    }
}