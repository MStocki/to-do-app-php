<?php

namespace App\Controller;

use App\Services\TaskActiveService;
use App\Services\TaskArchiveService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    private TaskActiveService $taskActiveService;
    private TaskArchiveService $taskArchiveService;

    public function __construct(
        TaskActiveService $taskActiveService,
        TaskArchiveService $taskArchiveService)
    {
        $this->taskActiveService = $taskActiveService;
        $this->taskArchiveService = $taskArchiveService;
    }

    #[Route('/task/active/new', name: 'taskActiveNew')]
    public function createTaskActive(Request $request): Response
    {
        return $this->taskActiveService->createTaskActive($request);
    }

    #[Route('/task/active/edit/{id}', name: 'taskActiveEdit')]
    public function editTaskActive(Request $request, int $id): Response
    {
        return $this->taskActiveService->editTaskActive($request,$id);
    }

    #[Route('/task/active/close/{id}', name: 'taskActiveClose')]
    public function closeTaskActive(Request $request, int $id): Response
    {
        return $this->taskActiveService->closeTaskActive($request,$id);
    }

    #[Route('/task', name: 'task')]
    public function index(): Response
    {
        return $this->render('task/index.html.twig', [
        ]);
    }

    #[Route('/task/active/{id}', name: 'taskActiveDetails', methods: ['GET'])]
    public function  taskActiveDetail(int $id):Response
    {
        return $this->taskActiveService->taskActiveDetail($id);
    }

    #[Route('/task/archive/{id}', name: 'taskArchiveDetails', methods: ['GET'])]
    public function taskArchiveDetail(int $id): Response
    {
        return $this->taskArchiveService->taskArchiveDetail($id);
    }

    #[Route('/task/active/{id}/close', name: 'taskActiveClose', methods: ['POST'])]
    public function closeActiveTask(int $id):Response
    {
        return $this->taskActiveService->closeTaskActive($id);
    }

}
