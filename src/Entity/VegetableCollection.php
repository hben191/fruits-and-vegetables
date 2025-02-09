<?php

namespace App\Entity;

use App\Repository\VegetableCollectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VegetableCollectionRepository::class)]
class VegetableCollection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Vegetable>
     */
    #[ORM\OneToMany(targetEntity: Vegetable::class, mappedBy: 'vegetableCollection', cascade: ['persist', 'remove'])]
    private Collection $vegetables;

    public function __construct()
    {
        $this->vegetables = new ArrayCollection();
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
        return array_values(array_map(fn(Vegetable $vegetable) => [
            'id' => $vegetable->getId(),
            'name' => $vegetable->getName(),
            'weight' => $vegetable->getUnit() === 'kg' ? $vegetable->getQuantity() * 1000 : $vegetable->getQuantity()
        ], array_filter($this->vegetables->toArray(), function (Vegetable $vegetable) use ($name, $minWeight, $maxWeight) {
            $weightInGrams = $vegetable->getUnit() === 'kg' ? $vegetable->getQuantity() * 1000 : $vegetable->getQuantity();
            if ($name && stripos($vegetable->getName(), $name) === false) {
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


    public function add(Vegetable $vegetable): static
    {
        if (!$this->vegetables->contains($vegetable)) {
            $this->vegetables->add($vegetable);
            $vegetable->setVegetableCollection($this);
        }

        return $this;
    }

    public function remove(Vegetable $vegetable): static
    {
        if ($this->vegetables->removeElement($vegetable)) {
            if ($vegetable->getVegetableCollection() === $this) {
                $vegetable->setVegetableCollection(null);
            }
        }

        return $this;
    }
}
