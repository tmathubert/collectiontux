<?php

namespace App\Entity;

use App\Repository\VitrineTuxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VitrineTuxRepository::class)]
class VitrineTux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: CarteTux::class)]
    private Collection $cartesTux;

    #[ORM\ManyToOne(inversedBy: 'vitrinesTux')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MembreTux $membretux = null;

    #[ORM\Column]
    private ?bool $ispublic = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    public function __construct()
    {
        $this->cartesTux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, CarteTux>
     */
    public function getCartesTux(): Collection
    {
        return $this->cartesTux;
    }

    public function addCartesTux(CarteTux $vitrineTux): static
    {
        if (!$this->cartesTux->contains($vitrineTux)) {
            $this->cartesTux->add($vitrineTux);
        }

        return $this;
    }

    public function removeCartesTux(CarteTux $vitrineTux): static
    {
        $this->cartesTux->removeElement($vitrineTux);

        return $this;
    }

    public function getMembretux(): ?MembreTux
    {
        return $this->membretux;
    }

    public function setMembretux(?MembreTux $membretux): static
    {
        $this->membretux = $membretux;

        return $this;
    }

    public function isIspublic(): ?bool
    {
        return $this->ispublic;
    }

    public function setIspublic(bool $ispublic): static
    {
        $this->ispublic = $ispublic;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }
    public function __toString(): string
    {
        return $this->getName();
    }
}
