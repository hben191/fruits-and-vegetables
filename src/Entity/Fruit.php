<?php

namespace App\Entity;

use App\Repository\FruitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FruitRepository::class)]
class Fruit extends AbstractFood
{
    #[ORM\ManyToOne(inversedBy: 'Fruits')]
    private ?FruitCollection $fruitCollection = null;

    public function getFruitCollection(): ?FruitCollection
    {
        return $this->fruitCollection;
    }

    public function setFruitCollection(?FruitCollection $fruitCollection): static
    {
        $this->fruitCollection = $fruitCollection;

        return $this;
    }
}
