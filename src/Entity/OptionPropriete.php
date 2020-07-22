<?php

namespace App\Entity;

use App\Repository\OptionProprieteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OptionProprieteRepository::class)
 * @ORM\Table(name="`option`")
 */
class OptionPropriete
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=120)
     */
    private $intitule;

    /**
     * @ORM\ManyToMany(targetEntity=Propriete::class, mappedBy="options")
     */
    private $proprietes;

    public function __construct()
    {
        $this->proprietes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }

    /**
     * @return Collection|Propriete[]
     */
    public function getProprietes(): Collection
    {
        return $this->proprietes;
    }

    public function addPropriete(Propriete $propriete): self
    {
        if (!$this->proprietes->contains($propriete)) {
            $this->proprietes[] = $propriete;
        }

        return $this;
    }

    public function removePropriete(Propriete $propriete): self
    {
        if ($this->proprietes->contains($propriete)) {
            $this->proprietes->removeElement($propriete);
        }

        return $this;
    }

    /** Indispensable pour designer l'objet OptiontPropriete en tant que champ d'un formulaire
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getIntitule();
    }
}
