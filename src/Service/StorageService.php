<?php

namespace App\Service;

use App\Collection\FruitCollection;
use App\Collection\VegetableCollection;
use App\Entity\Fruit;
use App\Entity\Vegetable;

class StorageService
{
    protected string $request = '';
    private FruitCollection $fruitCollection;
    private VegetableCollection $vegetableCollection;

    public function __construct(
        string $request
    ) {
        $this->request = $request;
        $this->fruitCollection = FruitCollection::createEmpty();
        $this->vegetableCollection = VegetableCollection::createEmpty();
    }

    /**
     * Reads the json data and stores them into fruitCollection and vegetableCollection
     *
     * @return bool Only if all the data has been stored correctly returns true
     */
    public function loadData(): bool
    {
        $array = json_decode($this->request, true);

        foreach ($array as $data) {
            if ($data['type'] === 'fruit') {
                $this->fruitCollection->add(new Fruit($data['id'], $data['name'], $data['quantity'], $data['unit']));
            } elseif ($data['type'] === 'vegetable') {
                $this->vegetableCollection->add(new Vegetable($data['id'], $data['name'], $data['quantity'], $data['unit']));
            }
        }

        // Might perform some other actions with the collections here or then call the getters of the Class...

        return $this->fruitCollection->count() + $this->vegetableCollection->count() === count($array) ? true : false;
    }

    public function getRequest(): string
    {
        return $this->request;
    }

    public function getVegetableCollection(): VegetableCollection
    {
        return $this->vegetableCollection;
    }

    public function getFruitCollection(): FruitCollection
    {
        return $this->fruitCollection;
    }
}
