<?php

namespace App\Services;

use App\Entity\Task;
use App\Form\AddTask;
use App\Form\EditTask;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use DateTime;

class TaskService extends AbstractController
{
    private TaskRepository $taskRepository;


    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function createTask(Request $request): Response
    {
        $user=$this->getUser();
        $task = new Task();
        $task->setUser($user);
        $task->setCreatedAt(new DateTime());
        $task->setIsActive(true);
        $form=$this->createForm(AddTask::class, $task);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->taskRepository->create($task);
            return $this->redirectToRoute('task');
        }

        return $this->render('task/addTask.html.twig', [
            'addTaskForm' => $form->createView(),
        ]);
    }

    public function taskActiveDetail(int $id): Response
    {
        $task = $this->taskRepository->find($id);

        return $this->render('task/taskActiveDetails.html.twig', [
            'id' => $id,
            'name' => $task->getName(),
            'description' =>$task->getDescription(),
            'status' =>$task->getStatus(),
            'createdAt'=>$task->getCreatedAt()->format('d/m/Y'),
            'deadline'=>$task->getDeadline()->format('d/m/Y')
        ]);
    }

    public function taskArchiveDetail(int $id): Response
    {
        $task = $this->taskRepository->find($id);

        return $this->render('task/taskArchiveDetails.html.twig', [
            'id' => $id,
            'name' => $task->getName(),
            'description' =>$task->getDescription(),
            'status' =>$task->getStatus(),
            'createdAt'=>$task->getCreatedAt()->format('d/m/Y'),
            'deadline'=>$task->getDeadline()->format('d/m/Y')
        ]);
    }

    public function editTask(Request $request, int $id): Response
    {
        $task = $this->taskRepository->find($id);
        $form=$this->createForm(EditTask::class, $task);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->taskRepository->flush();
            return $this->redirectToRoute('taskActiveDetails',['id' =>$id]);
        }
        return $this->render('task/editTask.html.twig', [
            'editTaskForm' => $form->createView(),
            'name' =>$task->getName(),
            'status'=>$task->getStatus(),
            'createdAt'=>$task->getCreatedAt()->format('d/m/Y'),
            'deadline'=>$task->getDeadline()->format('d/m/Y')
    ]);
    }

    public function closeTask(int $id):Response
    {
        $task = $this->taskRepository->find($id);
        $task->setIsActive(false);
        $this->taskRepository->flush();
        return new JsonResponse(['Przeniesiono zadanie do archiwum. Nr zadania: '=> $id]);
    }

    public function getActiveTasks()
    {
        $user=$this->getUser();
        return $this->taskRepository->getActiveTasks($user);
    }

    public function getArchiveTasks()
    {
        $user=$this->getUser();
        return $this->taskRepository->getArchiveTasks($user);
    }

    public function deleteTask(int $id):void
    {
        $this->taskRepository->delete($id);
    }

}