<?php

namespace App\Controller;
use App\Entity\TaskActive;
use App\Entity\TaskArchive;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class TaskController extends AbstractController
{
    // public function createTaskActive(ManagerRegistry $doctrine): Response
    // {
    //     $entityManager = $doctrine->getManager();

    //     $task = new TaskActive();

    // }

    #[Route('/task', name: 'task')]
    public function index(): Response
    {
        return $this->render('task/index.html.twig', [
        ]);
    }
    /**
     * @Route("/task/active/{id}", name="taskActiveDetails", requirements={"id"="\d+"})
     */
    public function taskActiveDetail(ManagerRegistry $doctrine, int $id): Response
    {
        $task = $doctrine->getRepository(TaskActive::class)->find($id);


        return $this->render('task/taskActiveDetails.html.twig', [
            'name' => $task->getName(),
            'description' =>$task->getDescription(),
            'status'=>$task->getStatus(),
            'createdAt'=>$task->getCreatedAt()->format('d/m/Y'),
            'deadline'=>$task->getDeadline()->format('d/m/Y')
        ]);
    }
     /**
     * @Route("/task/archive/{id}", name="taskArchiveDetails", requirements={"id"="\d+"})
     */
    public function taskArchiveDetail(ManagerRegistry $doctrine, int $id): Response
    {
        $task = $doctrine->getRepository(TaskActive::class)->find($id);

        return $this->render('task/taskArchiveDetails.html.twig', [
            'name' => $task->getName(),
            'description' =>$task->getDescription(),
            'status'=>$task->getStatus(),
            'createdAt'=>$task->getCreatedAt()->format('d/m/Y'),
            'deadline'=>$task->getDeadline()->format('d/m/Y')

        ]);
    }
}
