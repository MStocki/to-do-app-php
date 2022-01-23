<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\AddTask;
use App\Form\EditTask;
use App\Services\TaskService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    const dayToDeadline = 3;
    public function __construct(
        private TaskService $taskService
    ) {}


    #[Route(path: '/task/new', name: 'taskNew', methods:['GET','POST'])]
    public function createTask(Request $request): Response
    {
        $task = new Task();
        $form=$this->createForm(AddTask::class, $task);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->taskService->createTask($this->getUser(), $task);
            return $this->redirectToRoute('task');
        }

        return $this->render('task/addTask.html.twig', [
            'addTaskForm' => $form->createView(),
        ]);
    }

    #[Route(path: '/task/edit/{id}', name: 'taskEdit', methods:['GET','POST'])]
    public function editTask(Request $request, int $id): Response
    {
        $task = $this->taskService->getTask($id);
        $form=$this->createForm(EditTask::class, $task);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->taskService->editTask();
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

    #[Route(path: '/task', name: 'task', methods:['GET'])]
    public function index(): Response
    {
        $user = $this->getUser();
        $tasksActiveCloseToDeadline = $this->taskService->getActiveTasksCloseToDeadline($user,self::dayToDeadline);
        $tasksActive = $this->taskService->getActiveTasks($user,self::dayToDeadline);
        $tasksArchive = $this->taskService->getArchiveTasks($user);
        return $this->render('task/index.html.twig', [
            'tasksActiveCloseToDeadline' => $tasksActiveCloseToDeadline,
            'tasksActive' => $tasksActive,
            'tasksArchive' => $tasksArchive,
        ]);
    }

    #[Route(path: '/task/active/{id}', name: 'taskActiveDetails', methods: ['GET'])]
    public function  taskActiveDetail(int $id):Response
    {
        $task = $this->taskService->getTask($id);
        return $this->render('task/taskActiveDetails.html.twig', [
            'id' => $id,
            'name' => $task->getName(),
            'description' =>$task->getDescription(),
            'status' =>$task->getStatus(),
            'createdAt'=>$task->getCreatedAt()->format('d/m/Y'),
            'deadline'=>$task->getDeadline()->format('d/m/Y')
        ]);
    }

    #[Route(path: '/task/archive/{id}', name: 'taskArchiveDetails', methods: ['GET'])]
    public function  taskArchiveDetail(int $id):Response
    {
        $task = $this->taskService->getTask($id);
        return $this->render('task/taskArchiveDetails.html.twig', [
            'id' => $id,
            'name' => $task->getName(),
            'description' =>$task->getDescription(),
            'status' =>$task->getStatus(),
            'createdAt'=>$task->getCreatedAt()->format('d/m/Y'),
            'deadline'=>$task->getDeadline()->format('d/m/Y')
        ]);
    }

    #[Route(path: '/task/{id}/close', name: 'taskClose', methods: ['POST'])]
    public function closeTask(int $id):Response
    {
        $this->taskService->closeTask($id);
        return new JsonResponse(['Przeniesiono zadanie do archiwum. Nr zadania: '=> $id]);
    }

    #[Route(path: '/task/{id}/delete', name: 'taskDelete', methods: ['GET'])]
    public function deleteTask(int $id):Response
    {
        $this->taskService->deleteTask($id);
        return $this->redirectToRoute('task');
    }
}
