<?php

namespace App\Util;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

abstract class Collection implements IteratorAggregate
{
    public function __construct(protected array $elements)
    {
    }

    public static function createEmpty(): static
    {
        return new static([]);
    }


    public function filter(callable $fn): static
    {
        return new static(array_filter($this->elements, $fn, ARRAY_FILTER_USE_BOTH));
    }


    public function add(mixed $element): void
    {
        $this->elements[] = $element;
    }

    public function remove($index): void
    {
        if (!isset($this->elements[$index])) {
            throw new \OutOfBoundsException("Index $index does not exist in the collection.");
        }

        unset($this->elements[$index]);
        $this->elements = array_values($this->elements); // Re-index the array
    }

    public function items(): array
    {
        return $this->elements;
    }

    public static function fromMap(array $items, callable $fn): static
    {
        return new static(array_map($fn, $items));
    }

    public function map(callable $fn): array
    {
        return array_map($fn, $this->elements);
    }

    public function count(): int
    {
        return count($this->elements);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->elements);
    }
}
