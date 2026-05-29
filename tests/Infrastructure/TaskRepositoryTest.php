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

namespace TaskForge\Tests\Infrastructure;

use PHPUnit\Framework\TestCase;
use TaskForge\Infrastructure\TaskRepositorySQLite;
use TaskForge\Infrastructure\TaskRepositoryJSON;
use TaskForge\Domain\Task;
use TaskForge\Domain\TaskStatus;
use PDO;

class TaskRepositoryTest extends TestCase
{
    private string $jsonTestFile = __DIR__ . '/../../data/test_tasks.json';

    protected function tearDown(): void
    {
        if (file_exists($this->jsonTestFile)) {
            unlink($this->jsonTestFile);
        }
    }

    public function testSQLiteRepositoryIntegration(): void
    {
        $pdo = new PDO("sqlite::memory:");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $repo = new TaskRepositorySQLite($pdo);

        // 1. Create and save task
        $task = new Task(null, "Test sqlite repository");
        $savedTask = $repo->save($task);

        $this->assertNotNull($savedTask->getId());
        $this->assertEquals("Test sqlite repository", $savedTask->getDescription());

        // 2. Find all tasks
        $all = $repo->findAll();
        $this->assertCount(1, $all);
        $this->assertEquals($savedTask->getId(), $all[0]->getId());

        // 3. Find by ID
        $found = $repo->findById($savedTask->getId());
        $this->assertNotNull($found);
        $this->assertEquals($savedTask->getId(), $found->getId());

        // 4. Update task (Complete)
        $found->complete();
        $repo->save($found);
        $updated = $repo->findById($savedTask->getId());
        $this->assertEquals(TaskStatus::Completed, $updated->getStatus());

        // 5. Delete task
        $this->assertTrue($repo->delete($savedTask->getId()));
        $this->assertNull($repo->findById($savedTask->getId()));
    }

    public function testJSONRepositoryIntegration(): void
    {
        if (file_exists($this->jsonTestFile)) {
            unlink($this->jsonTestFile);
        }
        $repo = new TaskRepositoryJSON($this->jsonTestFile);

        // 1. Create and save task
        $task = new Task(null, "Test json repository");
        $savedTask = $repo->save($task);

        $this->assertNotNull($savedTask->getId());
        $this->assertEquals("Test json repository", $savedTask->getDescription());

        // 2. Find all tasks
        $all = $repo->findAll();
        $this->assertCount(1, $all);
        $this->assertEquals($savedTask->getId(), $all[0]->getId());

        // 3. Find by ID
        $found = $repo->findById($savedTask->getId());
        $this->assertNotNull($found);
        $this->assertEquals($savedTask->getId(), $found->getId());

        // 4. Update task (Complete)
        $found->complete();
        $repo->save($found);
        $updated = $repo->findById($savedTask->getId());
        $this->assertEquals(TaskStatus::Completed, $updated->getStatus());

        // 5. Delete task
        $this->assertTrue($repo->delete($savedTask->getId()));
        $this->assertNull($repo->findById($savedTask->getId()));
    }
}
