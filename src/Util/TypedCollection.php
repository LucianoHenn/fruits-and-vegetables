<?php

namespace App\Util;

use Webmozart\Assert\Assert;

abstract class TypedCollection extends Collection
{
    public function __construct(array $elements = [])
    {
        Assert::allIsInstanceOf($elements, $this->type());

        parent::__construct($elements);
    }

    abstract protected function type(): string;

    public function add(mixed $element): void
    {
        Assert::isInstanceOf($element, $this->type());

        parent::add($element);
    }

    public function search($property, $comp, $value)
    {
        $this->ensureHasProperty($property);
        return $this->filter(
            function ($element) use ($property, $comp, $value) {
                switch ($comp) {
                    case '=':
                    case '==':
                        return $element->$property == $value;
                    case '===':
                        return $element->$property === $value;
                    case '!=':
                    case '<>':
                        return $element->$property != $value;
                    case '!==':
                        return $element->$property !== $value;
                    case '<':
                        return $element->$property < $value;
                    case '>':
                        return $element->$property > $value;
                    case '<=':
                        return $element->$property <= $value;
                    case '>=':
                        return $element->$property >= $value;
                    default:
                        throw new \InvalidArgumentException("Invalid comparison operator '$comp'.");
                }
            }
        );
    }

    private function ensureHasProperty(string $property): void
    {
        $type = $this->type();
        if (!property_exists($type, $property)) {
            throw new \InvalidArgumentException("Property '$property' does not exist on type '$type'.");
        }
    }

}
