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
use DateTimeImmutable;
use RuntimeException;

class TaskRepositoryJSON implements TaskRepositoryInterface
{
    private string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
        $this->ensureFileExists();
    }

    private function ensureFileExists(): void
    {
        $dir = dirname($this->filePath);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        if (!file_exists($this->filePath)) {
            file_put_contents($this->filePath, json_encode([], JSON_PRETTY_PRINT));
        }
    }

    /**
     * @return array<int, array{id: int, description: string, status: string, created_at: string}>
     */
    private function loadRawData(): array
    {
        if (!file_exists($this->filePath)) {
            return [];
        }
        $content = file_get_contents($this->filePath);
        $data = json_decode($content, true);
        return is_array($data) ? $data : [];
    }

    /**
     * @param array<int, array{id: int, description: string, status: string, created_at: string}> $data
     */
    private function saveRawData(array $data): void
    {
        $json = json_encode(array_values($data), JSON_PRETTY_PRINT);
        if ($json === false) {
            throw new RuntimeException("Failed to encode tasks to JSON.");
        }
        // Write using flock for concurrency protection
        $fp = fopen($this->filePath, 'c');
        if ($fp === false) {
            throw new RuntimeException("Failed to open database file: " . $this->filePath);
        }
        if (flock($fp, LOCK_EX)) {
            ftruncate($fp, 0);
            fwrite($fp, $json);
            fflush($fp);
            flock($fp, LOCK_UN);
        } else {
            throw new RuntimeException("Failed to acquire lock for database file: " . $this->filePath);
        }
        fclose($fp);
    }

    public function save(Task $task): Task
    {
        $tasksData = $this->loadRawData();

        if ($task->getId() === null) {
            // Generate next ID
            $maxId = 0;
            foreach ($tasksData as $item) {
                if (isset($item['id']) && $item['id'] > $maxId) {
                    $maxId = (int)$item['id'];
                }
            }
            $task->setId($maxId + 1);
            $tasksData[] = [
                'id' => $task->getId(),
                'description' => $task->getDescription(),
                'status' => $task->getStatus()->value,
                'created_at' => $task->getCreatedAt()->format(DateTimeImmutable::ATOM)
            ];
        } else {
            $found = false;
            foreach ($tasksData as &$item) {
                if (isset($item['id']) && (int)$item['id'] === $task->getId()) {
                    $item['description'] = $task->getDescription();
                    $item['status'] = $task->getStatus()->value;
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $tasksData[] = [
                    'id' => $task->getId(),
                    'description' => $task->getDescription(),
                    'status' => $task->getStatus()->value,
                    'created_at' => $task->getCreatedAt()->format(DateTimeImmutable::ATOM)
                ];
            }
        }

        $this->saveRawData($tasksData);
        return $task;
    }

    /**
     * @return Task[]
     */
    public function findAll(): array
    {
        $tasksData = $this->loadRawData();
        $tasks = [];
        foreach ($tasksData as $item) {
            $tasks[] = new Task(
                (int)$item['id'],
                $item['description'],
                TaskStatus::from($item['status']),
                new DateTimeImmutable($item['created_at'])
            );
        }

        // Sort by created_at DESC
        usort($tasks, function (Task $a, Task $b) {
            return $b->getCreatedAt() <=> $a->getCreatedAt();
        });

        return $tasks;
    }

    public function findById(int $id): ?Task
    {
        $tasksData = $this->loadRawData();
        foreach ($tasksData as $item) {
            if (isset($item['id']) && (int)$item['id'] === $id) {
                return new Task(
                    (int)$item['id'],
                    $item['description'],
                    TaskStatus::from($item['status']),
                    new DateTimeImmutable($item['created_at'])
                );
            }
        }
        return null;
    }

    public function delete(int $id): bool
    {
        $tasksData = $this->loadRawData();
        $initialCount = count($tasksData);
        $tasksData = array_filter($tasksData, function ($item) use ($id) {
            return !isset($item['id']) || (int)$item['id'] !== $id;
        });

        if (count($tasksData) !== $initialCount) {
            $this->saveRawData($tasksData);
            return true;
        }
        return false;
    }
}
