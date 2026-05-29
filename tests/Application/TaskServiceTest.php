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

namespace TaskForge\Tests\Application;

use PHPUnit\Framework\TestCase;
use TaskForge\Application\TaskService;
use TaskForge\Domain\Task;
use TaskForge\Domain\TaskRepositoryInterface;
use TaskForge\Domain\TaskStatus;

class TaskServiceTest extends TestCase
{
    public function testCreateTaskSavesToRepository(): void
    {
        $mockRepo = $this->createMock(TaskRepositoryInterface::class);
        $mockRepo->expects($this->once())
            ->method('save')
            ->with($this->callback(function (Task $task) {
                return $task->getDescription() === "Hacer la comida";
            }))
            ->willReturnCallback(function (Task $task) {
                $task->setId(42);
                return $task;
            });

        $service = new TaskService($mockRepo);
        $task = $service->createTask("Hacer la comida");

        $this->assertEquals(42, $task->getId());
        $this->assertEquals("Hacer la comida", $task->getDescription());
    }

    public function testCompleteTaskChangesStatusAndSaves(): void
    {
        $task = new Task(10, "Tarea para completar");

        $mockRepo = $this->createMock(TaskRepositoryInterface::class);
        $mockRepo->expects($this->once())
            ->method('findById')
            ->with(10)
            ->willReturn($task);

        $mockRepo->expects($this->once())
            ->method('save')
            ->with($this->callback(function (Task $t) {
                return $t->getStatus() === TaskStatus::Completed;
            }))
            ->willReturn($task);

        $service = new TaskService($mockRepo);
        $result = $service->completeTask(10);

        $this->assertNotNull($result);
        $this->assertEquals(TaskStatus::Completed, $result->getStatus());
    }

    public function testDeleteTaskInvokesDeleteOnRepo(): void
    {
        $mockRepo = $this->createMock(TaskRepositoryInterface::class);
        $mockRepo->expects($this->once())
            ->method('delete')
            ->with(5)
            ->willReturn(true);

        $service = new TaskService($mockRepo);
        $this->assertTrue($service->deleteTask(5));
    }
}
