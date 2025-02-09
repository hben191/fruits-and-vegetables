<?php

namespace App\Entity\Interface;

use App\Entity\AbstractFood;

interface FoodCollectionInterface
{
    public function add(AbstractFood $food): void;

    /**
     * @return bool Return true if the object has been successfully removed, returns false if not
     */
    public function remove(AbstractFood $food): void;

    /**
     * @return array<int, AbstractFood>
     */
    public function list(): array;
}
