<?php

namespace App\Service;

use App\Entity\Fruit;
use App\Entity\FruitCollection;
use App\Entity\Vegetable;
use App\Entity\VegetableCollection;

class FoodStorageService extends StorageService
{
    /**
     * This method creates an array for Vegetable and Food Collections front a json input
     * @return array{
     *  fruits: FruitCollection,
     *  vegetables: VegetableCollection
     * }
     */
    public function createFoodCollections(): array
    {
        $foodArray = json_decode($this->getRequest(), true);
        $fruitCollection = new FruitCollection();
        $vegetableCollection = new VegetableCollection();

        foreach ($foodArray as $food) {
            if ('vegetable' == $food['type']) {
                $vegetable = new Vegetable();
                $vegetable->setName($food['name'])
                        ->setQuantity($food['quantity'])
                        ->setUnit($food['unit']);

                $vegetableCollection->add($vegetable);

                // No need to check further if it is a vegetable
                continue;
            }

            if ('fruit' == $food['type']) {
                $fruit = new Fruit();
                $fruit->setName($food['name'])
                        ->setQuantity($food['quantity'])
                        ->setUnit($food['unit']);

                $fruitCollection->add($fruit);
            }
        }

        return [
            'fruits' => $fruitCollection,
            'vegetables' => $vegetableCollection
        ];
    }
}
