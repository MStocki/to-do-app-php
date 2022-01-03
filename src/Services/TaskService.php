<?php

namespace App\Services;

use App\Entity\TaskActive;
use App\Form\AddTaskType;
use App\Repository\TaskActiveRepository;
use App\Repository\TaskArchiveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use DateTime;

class TaskService extends AbstractController
{
    private TaskActiveRepository $taskActiveRepository;
    private TaskArchiveRepository $taskArchiveRepository;

    public function __construct(
        TaskActiveRepository $taskActiveRepository,
        TaskArchiveRepository $taskArchiveRepository)
    {
        $this->taskActiveRepository = $taskActiveRepository;
        $this->taskArchiveRepository = $taskArchiveRepository;
    }

    public function createTaskActive(Request $request): Response
    {
        $user=$this->getUser();
        $task = new TaskActive();
        $task->setUser($user);
        $task->setCreatedAt(new DateTime());
        $form=$this->createForm(AddTaskType::class, $task);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->taskActiveRepository->persist($task);
            $this->taskActiveRepository->flush();
        }

        return $this->render('task/addTaskActive.html.twig', [
            'addTaskForm' => $form->createView(),
        ]);
    }

    public function taskActiveDetail(int $id): Response
    {
        $task = $this->taskActiveRepository->find($id);

        return $this->render('task/taskActiveDetails.html.twig', [
            'name' => $task->getName(),
            'description' =>$task->getDescription(),
            'createdAt'=>$task->getCreatedAt()->format('d/m/Y'),
            'deadline'=>$task->getDeadline()->format('d/m/Y')
        ]);
    }

    public function taskArchiveDetail(int $id): Response
    {
        $task = $this->taskArchiveRepository->find($id);

        return $this->render('task/taskArchiveDetails.html.twig', [
            'name' => $task->getName(),
            'description' =>$task->getDescription(),
            'status'=>$task->getStatus(),
            'createdAt'=>$task->getCreatedAt()->format('d/m/Y'),
            'deadline'=>$task->getDeadline()->format('d/m/Y')

        ]);
    }
}