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

require_once __DIR__ . '/bootstrap.php';

use TaskForge\Infrastructure\TaskRepositorySQLite;
use TaskForge\Infrastructure\TaskRepositoryJSON;
use TaskForge\Application\TaskService;
use TaskForge\Interface\TaskController;

$driver = $_ENV['DB_DRIVER'] ?? 'sqlite';

try {
    if ($driver === 'json') {
        $filePath = __DIR__ . '/' . ($_ENV['JSON_DB_PATH'] ?? 'data/tasks.json');
        $repository = new TaskRepositoryJSON($filePath);
    } else {
        $dbPath = __DIR__ . '/' . ($_ENV['SQLITE_DB_PATH'] ?? 'data/database.sqlite');
        // Ensure data directory exists
        $dir = dirname($dbPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $pdo = new PDO("sqlite:" . $dbPath);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $repository = new TaskRepositorySQLite($pdo);
    }

    $service = new TaskService($repository);
    $controller = new TaskController($service);
    $controller->handleRequest();
} catch (Exception $e) {
    die("Application Error: " . $e->getMessage());
}
