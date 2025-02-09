<?php

namespace App\Entity\Interface;

use App\Entity\AbstractFood;

interface FoodCollectionInterface
{
    /**
     * Add an AbstractFood object
     * @param AbstractFood $food Item to be added to the collection
     *
     * @return void
     */
    public function add(AbstractFood $food): void;

    /**
     * Remove an AbstractFood object
     * @param AbstractFood $food Item to be removed from the collection
     *
     * @return bool Return true if the object has been successfully removed, returns false if not
     */
    public function remove(AbstractFood $food): bool;

    /**
     * List all AbstractFoods in the collection
     *
     * @return array<int, AbstractFood>
     */
    public function list(): array;
}
