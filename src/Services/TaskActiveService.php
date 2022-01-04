<?php

namespace App\Services;

use App\Entity\TaskActive;
use App\Form\AddActiveTask;
use App\Form\EditActiveTask;
use App\Repository\TaskActiveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use DateTime;

class TaskActiveService extends AbstractController
{
    private TaskActiveRepository $taskActiveRepository;

    public function __construct(TaskActiveRepository $taskActiveRepository)
    {
        $this->taskActiveRepository = $taskActiveRepository;
    }

    public function createTaskActive(Request $request): Response
    {
        $user=$this->getUser();
        $task = new TaskActive();
        $task->setUser($user);
        $task->setCreatedAt(new DateTime());
        $form=$this->createForm(AddActiveTask::class, $task);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->taskActiveRepository->persist($task);
            $this->taskActiveRepository->flush();
            return $this->redirectToRoute('task');
        }

        return $this->render('task/addTaskActive.html.twig', [
            'addActiveTaskForm' => $form->createView(),
        ]);
    }

    public function taskActiveDetail(int $id): Response
    {
        $task = $this->taskActiveRepository->find($id);

        return $this->render('task/taskActiveDetails.html.twig', [
            'id' => $id,
            'name' => $task->getName(),
            'description' =>$task->getDescription(),
            'status' =>$task->getStatus(),
            'createdAt'=>$task->getCreatedAt()->format('d/m/Y'),
            'deadline'=>$task->getDeadline()->format('d/m/Y')
        ]);
    }

    public function editTaskActive(Request $request, int $id): Response
    {
        $task = $this->taskActiveRepository->find($id);
        $form=$this->createForm(EditActiveTask::class, $task);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->taskActiveRepository->flush();
            return $this->redirectToRoute('taskActiveDetails',['id' =>$id]);
        }
        return $this->render('task/editTaskActive.html.twig', [
            'editActiveTaskForm' => $form->createView(),
            'name' =>$task->getName(),
            'status'=>$task->getStatus(),
            'createdAt'=>$task->getCreatedAt()->format('d/m/Y'),
            'deadline'=>$task->getDeadline()->format('d/m/Y')
    ]);
    }

    public function closeTaskActive(Request $request, int $id):void
    {

    }
}