<?php

namespace App\Service;

use App\Entity\Fruit;
use App\Entity\Vegetable;

class FoodStorageService extends StorageService
{
    public function createFoodCollections()
    {
        $foodArray = json_decode($this->getRequest(), true);
        $fruitCollection = [];
        $vegetableCollection = [];

        foreach ($foodArray as $food) {
            if ('vegetable' == $food['type']) {
                $vegetable = new Vegetable();
                $vegetable->setName($food['name'])
                        ->setQuantity($food['quantity'])
                        ->setUnit($food['unit']);

                $vegetableCollection[] = $vegetable;

                // No need to check further if it is a vegetable
                continue;
            }

            if ('fruit' == $food['type']) {
                $fruit = new Fruit();
                $fruit->setName($food['name'])
                        ->setQuantity($food['quantity'])
                        ->setUnit($food['unit']);

                $fruitCollection[] = $fruit;
            }
        }

        return [
            'fruits' => $fruitCollection,
            'vegetables' => $vegetableCollection
        ];
    }
}
