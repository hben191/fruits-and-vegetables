<?php

namespace App\Entity;

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
    private Collection $fruits;

    public function __construct()
    {
        $this->fruits = new ArrayCollection();
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
     * @return array{
     *  array{
     *      id: int,
     *      name: string,
     *      weight: int
     *  }
     * }
     */
    public function list(
        ?string $name = null,
        ?int $minWeight = null,
        ?int $maxWeight = null
    ): array {
        return array_values(array_map(fn(Fruit $fruit) => [
            'id' => $fruit->getId(),
            'name' => $fruit->getName(),
            'weight' => $fruit->getUnit() === 'kg' ? $fruit->getQuantity() * 1000 : $fruit->getQuantity()
        ], array_filter($this->fruits->toArray(), function (Fruit $fruit) use ($name, $minWeight, $maxWeight) {
            $weightInGrams = $fruit->getUnit() === 'kg' ? $fruit->getQuantity() * 1000 : $fruit->getQuantity();
            if ($name && stripos($fruit->getName(), $name) === false) {
                return false;
            }
            if ($minWeight && $weightInGrams < $minWeight) {
                return false;
            }
            if ($maxWeight && $weightInGrams > $maxWeight) {
                return false;
            }
            return true;
        })));
    }

    public function add(Fruit $fruit): static
    {
        if (!$this->fruits->contains($fruit)) {
            $this->fruits->add($fruit);
            $fruit->setFruitCollection($this);
        }

        return $this;
    }

    public function remove(Fruit $fruit): static
    {
        if ($this->fruits->removeElement($fruit)) {
            if ($fruit->getFruitCollection() === $this) {
                $fruit->setFruitCollection(null);
            }
        }

        return $this;
    }
}
