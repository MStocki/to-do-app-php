<?php

namespace App\Repository;

use App\Entity\TaskArchive;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TaskArchive|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaskArchive|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaskArchive[]    findAll()
 * @method TaskArchive[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskArchiveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaskArchive::class);
    }
    public function persist(TaskArchive $task):void
    {
        $this->_em->persist($task);
    }
    public function flush():void
    {
        $this->_em->flush();
    }
    // /**
    //  * @return TaskArchive[] Returns an array of TaskArchive objects
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
    public function findOneBySomeField($value): ?TaskArchive
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
