<?php

namespace App\Entity;

class Fruit
{
    public float $quantity;
    public string $unit = 'g';

    public function __construct(
        public int $id,
        public string $name,
        float $quantity,
        string $unit,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->quantity = ($unit === 'kg') ? $quantity * 1000 : $quantity;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'quantity' => $this->quantity,
            'unit' => $this->unit
        ];
    }
}
