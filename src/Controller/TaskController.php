<?php

namespace App\Controller;

use App\Services\TaskService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class TaskController extends AbstractController
{
    private TaskService $taskService;

    public function __construct(TaskService $taskService){
        $this->taskService=$taskService;
    }

    #[Route('/task/new', name: 'taskNew')]
    public function createTaskActive(Request $request): Response
    {
        return $this->taskService->createTaskActive($request);
    }

    #[Route('/task', name: 'task')]
    public function index(): Response
    {
        return $this->render('task/index.html.twig', [
        ]);
    }

    #[Route('/task/{id}', name: 'taskActiveDetails', methods: ['GET'])]
    public function  taskActiveDetail(int $id):Response
    {
        return $this->taskService->taskActiveDetail($id);
    }

    #[Route('/task/{id}', name: 'taskArchiveDetails', methods: ['GET'])]
    public function taskArchiveDetail(ManagerRegistry $doctrine, int $id): Response
    {
        return $this->taskService->taskArchiveDetail($id);
    }
}
