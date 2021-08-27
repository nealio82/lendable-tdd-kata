<?php

declare(strict_types=1);

namespace Acme\ShoppingCart;

final class ShoppingCart
{
    private array $products = [];

    public function addProduct(Product $product, int $quantity = 1): void
    {
        for ($i = 0; $i < $quantity; $i++) {
            $this->products[] = $product;
        }
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function removeOne(Product $product): void
    {
        for ($i = 0; $i < count($this->products); $i++) {
            if ($this->products[$i]->equals($product)) {
                unset($this->products[$i]);
                return;
            }
        }

        throw new ProductDoesNotExistInCart();
    }

    public function removeAll(Product $product): void
    {
        $numProducts = count($this->products);
        for ($i = 0; $i < $numProducts; $i++) {
            if ($this->products[$i]->equals($product)) {
                unset($this->products[$i]);
            }
        }
    }

    public function getQuantityFor(Product $product): int
    {
        $matching = \array_filter($this->products, fn(Product $storedProduct) => $product->equals($storedProduct));

        return \count($matching);
    }

    public function getGrossValue(): int
    {
        return \array_sum(array_map(fn(Product $product) => $product->getPrice(), $this->products));
    }
}