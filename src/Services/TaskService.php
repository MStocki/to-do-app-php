<?php

declare(strict_types=1);

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

    public function createTask(User $user,Task $task): void
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

    public function editTask():void
    {
        $this->taskRepository->flush();
    }

    public function closeTask(int $id): void
    {
        $task = $this->taskRepository->find($id);
        $task->setIsActive(false);
        $this->taskRepository->flush();
    }

    public function getActiveTasks(User $user, int $daysToDeadline): array
    {
       return $this->taskRepository->getActiveTasks($user,$daysToDeadline);
    }

    public function getActiveTasksCloseToDeadline(User $user, int $daysToDeadline) : array
    {
        return $this->taskRepository->getActiveTaskCloseDeadline($user,$daysToDeadline);
    }

    public function getArchiveTasks(User $user): array
    {
        return $this->taskRepository->getArchiveTasks($user);
    }

    public function deleteTask(int $id): void
    {
        $this->taskRepository->delete($id);
    }

}