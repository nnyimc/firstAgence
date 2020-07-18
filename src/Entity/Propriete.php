<?php

namespace App\Entity;

use App\Repository\ProprieteRepository;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProprieteRepository", repositoryClass=ProprieteRepository::class)
 * @UniqueEntity("nom")
 */
class Propriete
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=3)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=500)
     * @Assert\Length(min=15)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(min=25, max=220)
     */
    private $surface;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range (min=1, max=6)
     */
    private $nbPieces;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Range (min=0, max=12)
     */
    private $etage;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range (min=1, max=4)
     */
    private $nbChambres;

    /**
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    private $vendue = false;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateAjout;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range (min=9000, max=1500000)
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity=Adresse::class, inversedBy="proprietes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $adresse;


    public function __construct() {
        $this->setDateAjout( new \DateTime());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getSlug(): string {
        return (new Slugify())->slugify($this->getNom());
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSurface(): ?int
    {
        return $this->surface;
    }

    public function setSurface(int $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getNbPieces(): ?int
    {
        return $this->nbPieces;
    }

    public function setNbPieces(int $nbPieces): self
    {
        $this->nbPieces = $nbPieces;

        return $this;
    }

    public function getEtage(): ?int
    {
        return $this->etage;
    }

    public function setEtage(?int $etage): self
    {
        $this->etage = $etage;

        return $this;
    }

    public function getNbChambres(): ?int
    {
        return $this->nbChambres;
    }

    public function setNbChambres(int $nbChambres): self
    {
        $this->nbChambres = $nbChambres;

        return $this;
    }

    public function getVendue(): ?bool
    {
        return $this->vendue;
    }

    public function setVendue(bool $vendue): self
    {
        $this->vendue = $vendue;

        return $this;
    }

    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->dateAjout;
    }

    public function setDateAjout(\DateTimeInterface $dateAjout): self
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function getPrixFormate(): string {
        return number_format($this->prix, 0, '', ' ');
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(?Adresse $adresse): self
    {
        $this->adresse = $adresse;
        return $this;
    }

}
