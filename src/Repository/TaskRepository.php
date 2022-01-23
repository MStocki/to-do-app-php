<?php

namespace App\Repository;

use App\Entity\Task;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function flush():void
    {
        $this->_em->flush();
    }

//
//    public function closeTaskActive($id):Task
//    {
//         $task = $this->find($id);
//         $this->_em->remove($task);
//         $this->_em->flush();
//         return $task;
//    }
    public function getActiveTasks(User $user,int $dayToDeadline)
    {
        $qb = $this->createQueryBuilder('t')
            ->where('t.user = :user')
            ->andWhere('t.isActive = 1')
            ->andWhere('t.deadline - CURRENT_DATE() > :dayToDeadline')
            ->setParameter('user', $user)
            ->setParameter('dayToDeadline', $dayToDeadline);
        $query = $qb->getQuery();
        return $query->execute();
    }
    public function getActiveTaskCloseDeadline(User $user, int $dayToDeadline)
    {
        $qb = $this->createQueryBuilder('t')
            ->select('t,t.deadline - CURRENT_DATE()')
            ->where('t.user = :user')
            ->andWhere('t.isActive = 1')
            ->andWhere('t.deadline - CURRENT_DATE() <= :dayToDeadline')
            ->setParameter('user', $user)
            ->setParameter('dayToDeadline', $dayToDeadline);
        $query = $qb->getQuery();
        return $query->execute();
    }
    public function getArchiveTasks(User $user)
    {
        $qb = $this->createQueryBuilder('t')
            ->where('t.user = :user')
            ->andWhere('t.isActive = 0')
            ->setParameter('user', $user);
        $query = $qb->getQuery();
        return $query->execute();
    }
    public function delete(int $id):void
    {
        $task= $this->find($id);
        $this->_em->remove($task);
        $this->_em->flush();
    }
    public function create(Task $task):void
    {
        $this->_em->persist($task);
        $this->_em->flush();
    }
}
