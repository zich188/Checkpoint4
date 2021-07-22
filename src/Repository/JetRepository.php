<?php

namespace App\Repository;

use App\Entity\Jet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Jet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Jet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Jet[]    findAll()
 * @method Jet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Jet::class);
    }

    // /**
    //  * @return Jet[] Returns an array of Jet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Jet
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
