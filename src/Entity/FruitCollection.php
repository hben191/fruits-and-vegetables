<?php

namespace App\Entity;

use App\Entity\Interface\FoodCollectionInterface;
use App\Repository\FruitCollectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FruitCollectionRepository::class)]
class FruitCollection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Fruit>
     */
    #[ORM\OneToMany(targetEntity: Fruit::class, mappedBy: 'fruitCollection', cascade: ['persist', 'remove'])]
    private Collection $Fruits;

    public function __construct()
    {
        $this->Fruits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Collection<int, Fruit>
     */
    public function get(): Collection
    {
        return $this->Fruits;
    }

    public function add(Fruit $fruit): static
    {
        if (!$this->Fruits->contains($fruit)) {
            $this->Fruits->add($fruit);
            $fruit->setFruitCollection($this);
        }

        return $this;
    }

    public function remove(Fruit $fruit): static
    {
        if ($this->Fruits->removeElement($fruit)) {
            if ($fruit->getFruitCollection() === $this) {
                $fruit->setFruitCollection(null);
            }
        }

        return $this;
    }
}
