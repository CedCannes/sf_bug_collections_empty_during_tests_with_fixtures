<?php

namespace App\Repository;

use App\Entity\Lane;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Lane|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lane|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lane[]    findAll()
 * @method Lane[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LaneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lane::class);
    }

    // /**
    //  * @return Lane[] Returns an array of Lane objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Lane
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
