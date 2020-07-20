<?php

namespace App\Repository;

use App\Entity\Propriete;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

    /** Cette méthode retourne les propriétés non vendues
     * @return \Doctrine\ORM\Query
     */
    public function findAllNotSoldQuery(): \Doctrine\ORM\Query
    {
        return $this->findUnsoldItems()
            ->getQuery()
            ;
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
