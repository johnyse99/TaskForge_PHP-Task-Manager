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

namespace TaskForge\Domain;

use DateTimeImmutable;
use InvalidArgumentException;

class Task
{
    private ?int $id;
    private string $description;
    private TaskStatus $status;
    private DateTimeImmutable $createdAt;

    public function __construct(
        ?int $id,
        string $description,
        TaskStatus $status = TaskStatus::Pending,
        ?DateTimeImmutable $createdAt = null
    ) {
        $this->id = $id;
        $this->setDescription($description);
        $this->status = $status;
        $this->createdAt = $createdAt ?? new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $trimmed = trim($description);
        if (empty($trimmed)) {
            throw new InvalidArgumentException("Task description cannot be empty.");
        }
        $this->description = $trimmed;
    }

    public function getStatus(): TaskStatus
    {
        return $this->status;
    }

    public function complete(): void
    {
        $this->status = TaskStatus::Completed;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
