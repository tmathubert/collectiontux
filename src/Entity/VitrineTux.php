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
    private Collection $VitrineTux;

    #[ORM\ManyToOne(inversedBy: 'vitrinesTux')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MembreTux $membretux = null;

    #[ORM\Column]
    private ?bool $ispublic = null;

    public function __construct()
    {
        $this->VitrineTux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, CarteTux>
     */
    public function getVitrineTux(): Collection
    {
        return $this->VitrineTux;
    }

    public function addVitrineTux(CarteTux $vitrineTux): static
    {
        if (!$this->VitrineTux->contains($vitrineTux)) {
            $this->VitrineTux->add($vitrineTux);
        }

        return $this;
    }

    public function removeVitrineTux(CarteTux $vitrineTux): static
    {
        $this->VitrineTux->removeElement($vitrineTux);

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
}
