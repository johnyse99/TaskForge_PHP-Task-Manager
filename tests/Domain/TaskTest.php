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

namespace TaskForge\Tests\Domain;

use PHPUnit\Framework\TestCase;
use TaskForge\Domain\Task;
use TaskForge\Domain\TaskStatus;
use InvalidArgumentException;
use DateTimeImmutable;

class TaskTest extends TestCase
{
    public function testCanBeCreatedWithValidData(): void
    {
        $task = new Task(1, "Hacer la tarea");
        $this->assertEquals(1, $task->getId());
        $this->assertEquals("Hacer la tarea", $task->getDescription());
        $this->assertEquals(TaskStatus::Pending, $task->getStatus());
        $this->assertInstanceOf(DateTimeImmutable::class, $task->getCreatedAt());
    }

    public function testThowsExceptionIfDescriptionIsEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Task(null, "   ");
    }

    public function testCanBeCompleted(): void
    {
        $task = new Task(null, "Test completing");
        $this->assertEquals(TaskStatus::Pending, $task->getStatus());
        $task->complete();
        $this->assertEquals(TaskStatus::Completed, $task->getStatus());
    }
}
