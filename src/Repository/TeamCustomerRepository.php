<?php

namespace App\Repository;

use App\Entity\TeamCustomer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TeamCustomer|null find($id, $lockMode = null, $lockVersion = null)
 * @method TeamCustomer|null findOneBy(array $criteria, array $orderBy = null)
 * @method TeamCustomer[]    findAll()
 * @method TeamCustomer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamCustomerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TeamCustomer::class);
    }

    // /**
    //  * @return TeamCustomer[] Returns an array of TeamCustomer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TeamCustomer
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
