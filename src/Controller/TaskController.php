<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\TaskActive;
use App\Entity\TaskArchive;
use App\Form\AddTaskType;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class TaskController extends AbstractController
{
    #[Route('/task/new', name: 'taskNew')]
    public function createTaskActive(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user=$this->getUser();
        $task = new TaskActive();
        $task->setUser($user);
        $task->setCreatedAt(new DateTime());
        $form=$this->createForm(AddTaskType::class, $task);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($task);
            $entityManager->flush();
        }

        return $this->render('task/addTaskActive.html.twig', [
            'addTaskForm' => $form->createView(),
        ]);
    }

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
