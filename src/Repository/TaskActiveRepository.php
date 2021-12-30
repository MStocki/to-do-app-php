<?php

namespace App\Repository;

use App\Entity\TaskActive;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TaskActive|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaskActive|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaskActive[]    findAll()
 * @method TaskActive[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskActiveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaskActive::class);
    }

    // /**
    //  * @return TaskActive[] Returns an array of TaskActive objects
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
    public function findOneBySomeField($value): ?TaskActive
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