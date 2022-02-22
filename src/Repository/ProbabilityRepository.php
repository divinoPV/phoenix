<?php

namespace App\Repository;

use App\Entity\Probability;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Probability|null find($id, $lockMode = null, $lockVersion = null)
 * @method Probability|null findOneBy(array $criteria, array $orderBy = null)
 * @method Probability[]    findAll()
 * @method Probability[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProbabilityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Probability::class);
    }

    // /**
    //  * @return Probability[] Returns an array of Probability objects
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
    public function findOneBySomeField($value): ?Probability
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
