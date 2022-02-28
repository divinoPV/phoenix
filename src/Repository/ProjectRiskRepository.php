<?php

namespace App\Repository;

use App\Entity\ProjectRisk;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProjectRisk|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectRisk|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectRisk[]    findAll()
 * @method ProjectRisk[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRiskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectRisk::class);
    }

    // /**
    //  * @return ProjectRisk[] Returns an array of ProjectRisk objects
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
    public function findOneBySomeField($value): ?ProjectRisk
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
