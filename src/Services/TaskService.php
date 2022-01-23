<?php

namespace App\Services;

use App\Entity\Task;
use App\Entity\User;
use App\Repository\TaskRepository;
use DateTimeImmutable;

class TaskService
{

    public function __construct(
        private TaskRepository $taskRepository
    ) {}

    public function createTask(User $user,Task $task)
    {
        $task->setUser($user);
        $task->setCreatedAt(new DateTimeImmutable());
        $task->setIsActive(true);
        $this->taskRepository->create($task);
    }

    public function getTask(int $id): Task
    {
        return $this->taskRepository->find($id);
    }

    public function editTask()
    {
        $this->taskRepository->flush();
    }

    public function closeTask(int $id)
    {
        $task = $this->taskRepository->find($id);
        $task->setIsActive(false);
        $this->taskRepository->flush();
    }

    public function getActiveTasks(User $user, int $daysToDeadline)
    {
       return $this->taskRepository->getActiveTasks($user,$daysToDeadline);
    }

    public function getActiveTasksCloseToDeadline(User $user, int $daysToDeadline)
    {
        return $this->taskRepository->getActiveTaskCloseDeadline($user,$daysToDeadline);
    }

    public function getArchiveTasks(User $user)
    {
        return $this->taskRepository->getArchiveTasks($user);
    }

    public function deleteTask(int $id):void
    {
        $this->taskRepository->delete($id);
    }

}