<?php


namespace App\Classes;


use DateTime;
use phpDocumentor\Reflection\Types\Integer;


class Recherche
{
    /**
     * @var Integer
     */
    private $prixMin;

    /**
     * @var Integer
     */
    private $prixMax;

    /**
     * @var DateTime
     */
    private $datePublication;

    /**
     * @var string
     */
    private $ville;

    /**
     * @var Integer
     */
    private $nbPieces;

    public function __construct(Integer $prixMin,Integer $prixMax, Integer $nbPieces, DateTime $datePublication, string $ville){
        $this->prixMin = $prixMin;
        $this->prixMax = $prixMax;
        $this->nbPieces = $nbPieces;
        $this->datePublication = $datePublication;
        $this->ville = $ville;
    }

    /**
     * @return Integer
     */
    public function getPrixMin(): Integer
    {
        return $this->prixMin;
    }

    /**
     * @param Integer $prixMin
     */
    public function setPrixMin(Integer $prixMin): void
    {
        $this->prixMin = $prixMin;
    }

    /**
     * @return Integer
     */
    public function getPrixMax(): Integer
    {
        return $this->prixMax;
    }

    /**
     * @param Integer $prixMax
     */
    public function setPrixMax(Integer $prixMax): void
    {
        $this->prixMax = $prixMax;
    }

    /**
     * @return DateTime
     */
    public function getDatePublication(): DateTime
    {
        return $this->datePublication;
    }

    /**
     * @param DateTime $datePublication
     */
    public function setDatePublication(DateTime $datePublication): void
    {
        $this->datePublication = $datePublication;
    }

    /**
     * @return string
     */
    public function getVille(): string
    {
        return $this->ville;
    }

    /**
     * @param string $ville
     */
    public function setVille(string $ville): void
    {
        $this->ville = $ville;
    }

    /**
     * @return Integer
     */
    public function getNbPieces(): Integer
    {
        return $this->nbPieces;
    }

    /**
     * @param Integer $nbPieces
     */
    public function setNbPieces(Integer $nbPieces): void
    {
        $this->nbPieces = $nbPieces;
    }

}