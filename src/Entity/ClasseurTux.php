<?php

namespace App\Entity;

use App\Repository\ClasseurTuxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClasseurTuxRepository::class)]
class ClasseurTux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(length:255, nullable:true)]
    private ?string $name = "";

    #[ORM\OneToMany(mappedBy: 'classeurTux', targetEntity: CarteTux::class)]
    private Collection $cartestux;

    public function __construct()
    {
        $this->cartestux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return Collection<int, CarteTux>
     */
    public function getCartestux(): Collection
    {
        return $this->cartestux;
    }
    public function setName(?string $name): void
    {
        $this->name=$name;
    }
    public function addCartestux(CarteTux $cartestux): static
    {
        if (!$this->cartestux->contains($cartestux)) {
            $this->cartestux->add($cartestux);
            $cartestux->setClasseurTux($this);
        }

        return $this;
    }

    public function removeCartestux(CarteTux $cartestux): static
    {
        if ($this->cartestux->removeElement($cartestux)) {
            // set the owning side to null (unless already changed)
            if ($cartestux->getClasseurTux() === $this) {
                $cartestux->setClasseurTux(null);
            }
        }

        return $this;
    }
}
