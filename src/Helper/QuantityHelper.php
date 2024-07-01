<?php

namespace App\Helper;

class QuantityHelper
{
    /**
     * Returns a callable that transforms an item by dividing its quantity by 1000.
     *
     * @return callable A callable that transforms an item.
     */
    public static function convertQuantitiesToKilograms(): callable
    {
        return function ($item) {
            if (isset($item->quantity)) {
                $item->quantity = round($item->quantity / 1000, 2); // Keep precision up to 2 decimal places;
                $item->unit = 'kg';
            }
            return $item;
        };
    }
}