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

namespace TaskForge\Interface;

use TaskForge\Application\TaskService;
use Exception;
use InvalidArgumentException;

class TaskController
{
    private TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function handleRequest(): void
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        if ($method === 'POST') {
            $this->handlePost();
        } else {
            $this->handleGet();
        }
    }

    private function handlePost(): void
    {
        // CSRF Verification
        $token = $_POST['csrf_token'] ?? '';
        if (empty($token) || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
            $this->redirectWithError("CSRF token verification failed.");
        }

        $action = $_POST['action'] ?? '';

        try {
            switch ($action) {
                case 'create':
                    $description = $_POST['description'] ?? '';
                    if (empty(trim($description))) {
                        throw new InvalidArgumentException("La descripción de la tarea no puede estar vacía.");
                    }
                    $this->taskService->createTask($description);
                    $this->redirectWithSuccess("Tarea creada exitosamente.");
                    break;

                case 'complete':
                    $id = (int)($_POST['id'] ?? 0);
                    if ($id <= 0) {
                        throw new InvalidArgumentException("Identificador de tarea no válido.");
                    }
                    $task = $this->taskService->completeTask($id);
                    if ($task === null) {
                        throw new Exception("No se encontró la tarea especificada.");
                    }
                    $this->redirectWithSuccess("Tarea completada exitosamente.");
                    break;

                case 'delete':
                    $id = (int)($_POST['id'] ?? 0);
                    if ($id <= 0) {
                        throw new InvalidArgumentException("Identificador de tarea no válido.");
                    }
                    $deleted = $this->taskService->deleteTask($id);
                    if (!$deleted) {
                        throw new Exception("No se pudo eliminar la tarea.");
                    }
                    $this->redirectWithSuccess("Tarea eliminada exitosamente.");
                    break;

                default:
                    throw new InvalidArgumentException("Acción no válida.");
            }
        } catch (Exception $e) {
            $this->redirectWithError($e->getMessage());
        }
    }

    private function handleGet(): void
    {
        try {
            $tasks = $this->taskService->listAllTasks();
        } catch (Exception $e) {
            $tasks = [];
            $_SESSION['flash']['error'] = "Error al recuperar tareas: " . $e->getMessage();
        }

        // Extract flash messages
        $flash = $_SESSION['flash'] ?? [];
        unset($_SESSION['flash']);

        // Load the view
        require_once __DIR__ . '/views/index.php';
    }

    private function redirectWithSuccess(string $message): void
    {
        $_SESSION['flash']['success'] = $message;
        header("Location: index.php");
        exit;
    }

    private function redirectWithError(string $message): void
    {
        $_SESSION['flash']['error'] = $message;
        header("Location: index.php");
        exit;
    }
}
