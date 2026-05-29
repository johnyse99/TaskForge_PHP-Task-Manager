<?php
/**
 * TaskForge - PHP Task Manager
 * 
 * Author: Juan S,
 * Copyright (C) 2026 Juan S.
 * 
 * This file is part of TaskForge.
 * 
 * TaskForge is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, version 3.
 * 
 * TaskForge is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 * 
 * You should have received a copy of the GNU Affero General Public License
 * along with TaskForge. If not, see <https://www.gnu.org/licenses/>.
 */

namespace TaskForge\Application;

use TaskForge\Domain\Task;
use TaskForge\Domain\TaskRepositoryInterface;
use TaskForge\Domain\TaskStatus;
use InvalidArgumentException;

class TaskService
{
    private TaskRepositoryInterface $repository;

    public function __construct(TaskRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function createTask(string $description): Task
    {
        $task = new Task(null, $description);
        return $this->repository->save($task);
    }

    /**
     * @return Task[]
     */
    public function listAllTasks(): array
    {
        return $this->repository->findAll();
    }

    public function completeTask(int $id): ?Task
    {
        $task = $this->repository->findById($id);
        if ($task === null) {
            return null;
        }
        $task->complete();
        return $this->repository->save($task);
    }

    public function deleteTask(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
