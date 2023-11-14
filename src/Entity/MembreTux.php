<?php

namespace App\Entity;

use App\Repository\MembreTuxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MembreTuxRepository::class)]
class MembreTux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $role = null;

    #[ORM\Column(length: 255)]
    private ?string $pseudo = null;

    #[ORM\OneToMany(mappedBy: 'membretux', targetEntity: VitrineTux::class, orphanRemoval: true)]
    private Collection $vitrinesTux;

    #[ORM\OneToMany(mappedBy: 'membreTux', targetEntity: ClasseurTux::class)]
    private Collection $classeursTux;
    public function __construct()
    {
        $this->vitrinesTux = new ArrayCollection();
        $this->classeursTux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClasseurstux(): Collection
    {
        return $this->classeursTux;
    }

    public function setClasseurstux(Collection $classeurstux): static
    {
        $this->classeursTux = $classeurstux;

        return $this;
    }
    public function addClasseursTux(ClasseurTux $classeurTux): static
    {
        if (!$this->classeursTux->contains($classeurTux)) {
            $this->classeursTux->add($classeurTux);
            $classeurTux->setMembretux($this);
        }
        return $this;
    }
    public function removeClasseursTux(ClasseurTux $classeurTux): static
    {
        if ($this->classeursTux->removeElement($classeurTux)) {
            // set the owning side to null (unless already changed)
            if ($classeurTux->getMembretux() === $this) {
                $classeurTux->setMembretux(null);
            }
        }

        return $this;
    }


    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * @return Collection<int, VitrineTux>
     */
    public function getVitrinesTux(): Collection
    {
        return $this->vitrinesTux;
    }

    public function addVitrinesTux(VitrineTux $vitrinesTux): static
    {
        if (!$this->vitrinesTux->contains($vitrinesTux)) {
            $this->vitrinesTux->add($vitrinesTux);
            $vitrinesTux->setMembretux($this);
        }

        return $this;
    }

    public function removeVitrinesTux(VitrineTux $vitrinesTux): static
    {
        if ($this->vitrinesTux->removeElement($vitrinesTux)) {
            // set the owning side to null (unless already changed)
            if ($vitrinesTux->getMembretux() === $this) {
                $vitrinesTux->setMembretux(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->pseudo;
    }
}
