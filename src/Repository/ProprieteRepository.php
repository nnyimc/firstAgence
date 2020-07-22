<?php

namespace App\Repository;

use App\Entity\Propriete;
use App\Entity\Recherche;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Propriete|null find($id, $lockMode = null, $lockVersion = null)
 * @method Propriete|null findOneBy(array $criteria, array $orderBy = null)
 * @method Propriete[]    findAll()
 * @method Propriete[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProprieteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Propriete::class);
    }

    /** Cette méthode retourne une requete filtrée qui vise les propriétés non vendues
     * @param Recherche $recherche
     * @return Query
     */
    public function findAllNotSoldQuery(Recherche $recherche): Query
    {
        $requete = $this->findUnsoldItems();

        //!! Ne pas mettre d'espaces entre le paramètre et la variable !!
        if ($recherche->getOptions()->count() > 0) {
            $k = 0; //Protection contre l'injection de code.
            foreach($recherche->getOptions() as $k => $option) {
                $k++;
                $requete = $requete
                    ->andWhere(":option$k MEMBER OF p.options")
                    ->setParameter("option$k", $option);
            }

        }

        if ($recherche->getPrixMax()) {
            $requete = $requete
                     ->andWhere('p.prix <= :prixMax')
                     ->setParameter('prixMax', $recherche->getPrixMax() )
                     ->orderBy('p.prix', 'ASC');
        }

        if ($recherche->getSurfaceMin()) {
            $requete = $requete
                ->andWhere('p.surface >= :surfaceMin')
                ->setParameter('surfaceMin', $recherche->getSurfaceMin() )
                ->orderBy('p.surface', 'ASC');
        }

        return $requete->getQuery();
    }


    /** Cette méthode retourne les propriétés les plus récentes invendues
     * @return Propriete[]
     */
    public function findNewestItems():array {
        return $this->findUnsoldItems()
            ->orderBy('p.dateAjout', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult()
            ;
    }

    /** Cette méthode un générateur de requêtes basé sur les propriétés invendues
     * @return QueryBuilder
     */
    private function findUnsoldItems():QueryBuilder {
        return $this->createQueryBuilder('p')
            ->andWhere('p.vendue = false')
            ;
    }


    // /**
    //  * @return Propriete[] Returns an array of Propriete objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Propriete
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
