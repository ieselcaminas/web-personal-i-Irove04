<?php

namespace App\Entity;

use App\Repository\ColorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ColorRepository::class)]
class Color
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nombre = null;

    /**
     * @var Collection<int, Pikmin>
     */
    #[ORM\OneToMany(targetEntity: Pikmin::class, mappedBy: 'color')]
    private Collection $pikmins;

    public function __construct()
    {
        $this->pikmins = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->Nombre;
    }

    public function setNombre(string $Nombre): static
    {
        $this->Nombre = $Nombre;

        return $this;
    }

    /**
     * @return Collection<int, Pikmin>
     */
    public function getPikmins(): Collection
    {
        return $this->pikmins;
    }

    public function addPikmin(Pikmin $pikmin): static
    {
        if (!$this->pikmins->contains($pikmin)) {
            $this->pikmins->add($pikmin);
            $pikmin->setColor($this);
        }

        return $this;
    }

    public function removePikmin(Pikmin $pikmin): static
    {
        if ($this->pikmins->removeElement($pikmin)) {
            // set the owning side to null (unless already changed)
            if ($pikmin->getColor() === $this) {
                $pikmin->setColor(null);
            }
        }

        return $this;
    }
}
