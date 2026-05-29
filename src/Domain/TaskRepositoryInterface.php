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

interface TaskRepositoryInterface
{
    /**
     * Save or update a task.
     */
    public function save(Task $task): Task;

    /**
     * Find all tasks.
     * @return Task[]
     */
    public function findAll(): array;

    /**
     * Find a task by its ID.
     */
    public function findById(int $id): ?Task;

    /**
     * Delete a task by its ID.
     */
    public function delete(int $id): bool;
}
