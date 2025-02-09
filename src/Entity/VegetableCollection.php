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
     * @return Collection<int, Vegetable>
     */
    public function getVegetables(): Collection
    {
        return $this->vegetables;
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
