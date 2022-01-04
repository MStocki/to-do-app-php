<?php

namespace App\Services;

use App\Form\AddActiveTask;
use App\Repository\TaskActiveRepository;
use App\Repository\TaskArchiveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use DateTime;

class TaskArchiveService extends AbstractController
{
    private TaskArchiveRepository $taskArchiveRepository;

    public function __construct(TaskArchiveRepository $taskArchiveRepository)
    {
        $this->taskArchiveRepository = $taskArchiveRepository;
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