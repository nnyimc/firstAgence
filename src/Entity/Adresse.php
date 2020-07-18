<?php

namespace App\Entity;

use App\Repository\AdresseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=AdresseRepository::class)
 */
class Adresse
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $rue;

    /**
     * @ORM\Column(type="string", length=120)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $codePostal;

    /**
     * @ORM\OneToMany(targetEntity=Propriete::class, mappedBy="adresse")
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

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): self
    {
        $this->rue = $rue;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;

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
            $propriete->setAdresse($this);
        }

        return $this;
    }

    public function removePropriete(Propriete $propriete): self
    {
        if ($this->proprietes->contains($propriete)) {
            $this->proprietes->removeElement($propriete);
            // set the owning side to null (unless already changed)
            if ($propriete->getAdresse() === $this) {
                $propriete->setAdresse(null);
            }
        }

        return $this;
    }

    /** Indispensable pour designer l'objet Adresse en tant que champ d'un formulaire
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getRue() . " " . $this->getCodePostal() . " " .$this->getVille();
    }
}
