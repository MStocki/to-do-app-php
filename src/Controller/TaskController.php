<?php

namespace App\Controller;

use App\Services\TaskService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    private TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    #[Route('/task/new', name: 'taskNew')]
    public function createTask(Request $request): Response
    {
        return $this->taskService->createTask($request);
    }

    #[Route('/task/edit/{id}', name: 'taskEdit')]
    public function editTask(Request $request, int $id): Response
    {
        return $this->taskService->editTask($request,$id);
    }

    #[Route('/task', name: 'task')]
    public function index(): Response
    {
        $tasksActive = $this->taskService->getActiveTasks();
        $tasksArchive = $this->taskService->getArchiveTasks();
        return $this->render('task/index.html.twig', [
            'tasksActive' => $tasksActive,
            'tasksArchive' => $tasksArchive,
        ]);
    }

    #[Route('/task/active/{id}', name: 'taskActiveDetails', methods: ['GET'])]
    public function  taskActiveDetail(int $id):Response
    {
        return $this->taskService->taskActiveDetail($id);
    }

    #[Route('/task/archive/{id}', name: 'taskArchiveDetails', methods: ['GET'])]
    public function  taskArchiveDetail(int $id):Response
    {
        return $this->taskService->taskArchiveDetail($id);
    }

    #[Route('/task/{id}/close', name: 'taskClose', methods: ['POST'])]
    public function closeTask(int $id):Response
    {
        return $this->taskService->closeTask($id);
    }

    #[Route('/task/{id}/delete', name: 'taskDelete', methods: ['GET'])]
    public function deleteTask(int $id):Response
    {
        $this->taskService->deleteTask($id);
        return $this->redirectToRoute('task');
    }
}
