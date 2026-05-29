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

namespace TaskForge\Infrastructure;

use TaskForge\Domain\Task;
use TaskForge\Domain\TaskRepositoryInterface;
use TaskForge\Domain\TaskStatus;
use PDO;
use DateTimeImmutable;

class TaskRepositorySQLite implements TaskRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->initializeSchema();
    }

    private function initializeSchema(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS tasks (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            description TEXT NOT NULL,
            status TEXT NOT NULL,
            created_at TEXT NOT NULL
        )";
        $this->pdo->exec($sql);
    }

    public function save(Task $task): Task
    {
        if ($task->getId() === null) {
            $stmt = $this->pdo->prepare(
                "INSERT INTO tasks (description, status, created_at) VALUES (:description, :status, :created_at)"
            );
            $stmt->execute([
                ':description' => $task->getDescription(),
                ':status' => $task->getStatus()->value,
                ':created_at' => $task->getCreatedAt()->format(DateTimeImmutable::ATOM)
            ]);
            $task->setId((int)$this->pdo->lastInsertId());
        } else {
            $stmt = $this->pdo->prepare(
                "UPDATE tasks SET description = :description, status = :status WHERE id = :id"
            );
            $stmt->execute([
                ':id' => $task->getId(),
                ':description' => $task->getDescription(),
                ':status' => $task->getStatus()->value
            ]);
        }
        return $task;
    }

    /**
     * @return Task[]
     */
    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM tasks ORDER BY created_at DESC");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $tasks = [];
        foreach ($rows as $row) {
            $tasks[] = new Task(
                (int)$row['id'],
                $row['description'],
                TaskStatus::from($row['status']),
                new DateTimeImmutable($row['created_at'])
            );
        }
        return $tasks;
    }

    public function findById(int $id): ?Task
    {
        $stmt = $this->pdo->prepare("SELECT * FROM tasks WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new Task(
            (int)$row['id'],
            $row['description'],
            TaskStatus::from($row['status']),
            new DateTimeImmutable($row['created_at'])
        );
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM tasks WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }
}
