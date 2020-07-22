<?php


namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

class Recherche
{
    /**
     * @var int | null
     * @Assert\Range (min=9000, max=1500000)
     */
    private $prixMax;

    /**
     * @var int | null
     * @Assert\Range (min=20, max=300)
     */
    private $surfaceMin;

    /**
     * @var ArrayCollection
     */
    private $options;

    public function __construct() {
        $this->options = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getOptions(): ArrayCollection
    {
        return $this->options;
    }

    /**
     * @param ArrayCollection $options
     */
    public function setOptions(ArrayCollection $options): void
    {
        $this->options = $options;
    }

    /**
     * @return int|null
     */
    public function getPrixMax(): ?int
    {
        return $this->prixMax;
    }

    /**
     * @param int|null $prixMax
     */
    public function setPrixMax(int $prixMax): void
    {
        $this->prixMax = $prixMax;
    }

    /**
     * @return int|null
     */
    public function getSurfaceMin(): ?int
    {
        return $this->surfaceMin;
    }

    /**
     * @param int|null $surfaceMin
     */
    public function setSurfaceMin(int $surfaceMin): void
    {
        $this->surfaceMin = $surfaceMin;
    }




}