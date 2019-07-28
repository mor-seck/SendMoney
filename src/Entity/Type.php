<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeRepository")
 */
class Type
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Personne", mappedBy="type")
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelleDuTypeDeRole;

    public function __construct()
    {
        $this->libelle = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Personne[]
     */
    public function getLibelle(): Collection
    {
        return $this->libelle;
    }

    public function addLibelle(Personne $libelle): self
    {
        if (!$this->libelle->contains($libelle)) {
            $this->libelle[] = $libelle;
            $libelle->setType($this);
        }

        return $this;
    }

    public function removeLibelle(Personne $libelle): self
    {
        if ($this->libelle->contains($libelle)) {
            $this->libelle->removeElement($libelle);
            // set the owning side to null (unless already changed)
            if ($libelle->getType() === $this) {
                $libelle->setType(null);
            }
        }

        return $this;
    }

    public function getLibelleDuTypeDeRole(): ?string
    {
        return $this->libelleDuTypeDeRole;
    }

    public function setLibelleDuTypeDeRole(string $libelleDuTypeDeRole): self
    {
        $this->libelleDuTypeDeRole = $libelleDuTypeDeRole;

        return $this;
    }
}
