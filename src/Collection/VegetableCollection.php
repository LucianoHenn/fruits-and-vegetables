<?php

namespace App\Collection;

use App\Util\TypedCollection;
use App\Entity\Vegetable;
use App\Helper\QuantityHelper;

final class VegetableCollection extends TypedCollection
{
    protected function type(): string
    {
        return Vegetable::class;
    }

    public function list($unit = 'g')
    {

        if ($unit !== 'g' && $unit !== 'kg') {
            throw new \InvalidArgumentException("Invalid unit. Expected 'g' or 'kg'");
        }

        $items = $this->items();
        return $unit === 'g' ? $items : $this->fromMap($items, QuantityHelper::convertQuantitiesToKilograms());
    }

}
