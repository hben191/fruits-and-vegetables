<?php

namespace App\Entity;

use App\Repository\VegetableRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VegetableRepository::class)]
class Vegetable extends AbstractFood
{
    #[ORM\ManyToOne(inversedBy: 'vegetables')]
    private ?VegetableCollection $vegetableCollection = null;

    public function getVegetableCollection(): ?VegetableCollection
    {
        return $this->vegetableCollection;
    }

    public function setVegetableCollection(?VegetableCollection $vegetableCollection): static
    {
        $this->vegetableCollection = $vegetableCollection;

        return $this;
    }
}
