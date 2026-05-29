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

use TaskForge\Domain\TaskStatus;

// Separate tasks by status
$pendingTasks = [];
$completedTasks = [];
foreach ($tasks as $task) {
    if ($task->getStatus() === TaskStatus::Pending) {
        $pendingTasks[] = $task;
    } else {
        $completedTasks[] = $task;
    }
}

$totalTasksCount = count($tasks);
$pendingCount = count($pendingTasks);
$completedCount = count($completedTasks);
$completionRate = $totalTasksCount > 0 ? round(($completedCount / $totalTasksCount) * 100) : 0;
$dbDriver = $_ENV['DB_DRIVER'] ?? 'sqlite';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskForge - Administrador de Tareas</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --bg-gradient-start: #0f172a;
            --bg-gradient-end: #1e1b4b;
            --card-bg: rgba(30, 41, 59, 0.7);
            --card-border: rgba(255, 255, 255, 0.08);
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --accent-primary: #6366f1;
            --accent-primary-hover: #4f46e5;
            --accent-success: #10b981;
            --accent-success-hover: #059669;
            --accent-danger: #f43f5e;
            --accent-danger-hover: #e11d48;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--bg-gradient-start) 0%, var(--bg-gradient-end) 100%);
            color: var(--text-primary);
            min-height: 100vh;
            padding-bottom: 50px;
        }

        h1, h2, h3, h4, .brand-font {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
        }

        /* Glassmorphism card styles */
        .glass-card {
            background: var(--card-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            box-shadow: 0 10px 30px 0 rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .glass-card:hover {
            box-shadow: 0 15px 35px 0 rgba(99, 102, 241, 0.15);
        }

        /* Top Brand Header */
        .brand-header {
            padding: 24px 0;
            border-bottom: 1px solid var(--card-border);
            margin-bottom: 40px;
        }

        .logo-icon {
            background: linear-gradient(135deg, #818cf8 0%, #4f46e5 100%);
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 22px;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
            margin-right: 12px;
        }

        /* Stat cards */
        .stat-card {
            padding: 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .stat-number {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 2px;
            font-family: 'Outfit', sans-serif;
        }

        .stat-label {
            font-size: 12px;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--accent-primary);
        }
        .stat-card.stat-pending::after {
            background: #f59e0b;
        }
        .stat-card.stat-completed::after {
            background: var(--accent-success);
        }
        .stat-card.stat-rate::after {
            background: #a855f7;
        }

        /* Form styling */
        .form-control {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid var(--card-border);
            color: white;
            padding: 14px 20px;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(15, 23, 42, 0.8);
            border-color: var(--accent-primary);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.25);
            color: white;
        }

        .btn-custom {
            padding: 14px 24px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: none;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }

        .btn-primary-custom:hover {
            background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
            color: white;
        }

        /* List view card styling */
        .task-item {
            padding: 18px 24px;
            border-bottom: 1px solid var(--card-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: background-color 0.3s ease;
        }

        .task-item:last-child {
            border-bottom: none;
        }

        .task-item:hover {
            background-color: rgba(255, 255, 255, 0.02);
        }

        .task-title {
            font-weight: 500;
            font-size: 15px;
            word-break: break-word;
        }

        .task-meta {
            font-size: 11px;
            color: var(--text-secondary);
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .task-completed .task-title {
            text-decoration: line-through;
            color: var(--text-secondary);
        }

        /* Buttons on tasks */
        .action-btn {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--card-border);
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .action-btn-success:hover {
            background: var(--accent-success);
            color: white;
            border-color: var(--accent-success);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .action-btn-danger:hover {
            background: var(--accent-danger);
            color: white;
            border-color: var(--accent-danger);
            box-shadow: 0 4px 12px rgba(244, 63, 94, 0.3);
        }

        /* Empty states */
        .empty-state {
            padding: 40px 20px;
            text-align: center;
            color: var(--text-secondary);
        }

        .empty-state i {
            font-size: 48px;
            color: rgba(99, 102, 241, 0.4);
            margin-bottom: 16px;
            display: block;
        }

        /* Flash notifications */
        .alert-custom {
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(8px);
            padding: 16px 20px;
            margin-bottom: 24px;
            color: white;
        }
        
        .alert-custom-success {
            background: rgba(16, 185, 129, 0.15);
            border-color: rgba(16, 185, 129, 0.3);
        }

        .alert-custom-danger {
            background: rgba(244, 63, 94, 0.15);
            border-color: rgba(244, 63, 94, 0.3);
        }

        /* Storage engine badge */
        .driver-badge {
            background: rgba(99, 102, 241, 0.12);
            color: #818cf8;
            border: 1px solid rgba(99, 102, 241, 0.3);
            border-radius: 30px;
            padding: 6px 14px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-transform: uppercase;
        }

        .driver-badge-json {
            background: rgba(168, 85, 247, 0.12);
            color: #c084fc;
            border-color: rgba(168, 85, 247, 0.3);
        }
    </style>
</head>
<body>

    <!-- Header Navigation -->
    <header class="brand-header">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="logo-icon">
                    <i class="bi bi-boxes"></i>
                </div>
                <div>
                    <span class="fs-4 brand-font text-white d-block">TaskForge</span>
                    <span class="text-secondary" style="font-size: 11px; letter-spacing: 0.5px; text-transform: uppercase;">PHP Task Manager</span>
                </div>
            </div>
            <div>
                <?php if ($dbDriver === 'json'): ?>
                    <span class="driver-badge driver-badge-json">
                        <i class="bi bi-filetype-json"></i> JSON Storage
                    </span>
                <?php else: ?>
                    <span class="driver-badge">
                        <i class="bi bi-database-fill-gear"></i> SQLite Database
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <div class="container">
        <!-- Flash Messages -->
        <?php if (!empty($flash['success'])): ?>
            <div class="alert alert-custom alert-custom-success d-flex align-items-center alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-3 fs-5 text-success"></i>
                <div><?= htmlspecialchars($flash['success']) ?></div>
                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (!empty($flash['error'])): ?>
            <div class="alert alert-custom alert-custom-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-3 fs-5 text-danger"></i>
                <div><?= htmlspecialchars($flash['error']) ?></div>
                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Stats Overview Row -->
        <div class="row g-4 mb-4">
            <div class="col-md-3 col-sm-6">
                <div class="glass-card stat-card">
                    <div class="stat-number text-white"><?= $totalTasksCount ?></div>
                    <div class="stat-label">Total</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="glass-card stat-card stat-pending">
                    <div class="stat-number text-warning"><?= $pendingCount ?></div>
                    <div class="stat-label">Pendientes</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="glass-card stat-card stat-completed">
                    <div class="stat-number text-success"><?= $completedCount ?></div>
                    <div class="stat-label">Completadas</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="glass-card stat-card stat-rate">
                    <div class="stat-number text-info"><?= $completionRate ?>%</div>
                    <div class="stat-label">Progreso</div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Left Side: Task Creation Form -->
            <div class="col-lg-4">
                <div class="glass-card p-4 h-100">
                    <h3 class="fs-5 mb-3 text-white">Nueva Tarea</h3>
                    <p class="text-secondary small mb-4">Ingresa una nueva actividad para agregarla a tu tablero del día de hoy.</p>
                    
                    <form action="index.php" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                        <input type="hidden" name="action" value="create">
                        
                        <div class="mb-4">
                            <label for="description" class="form-label text-secondary small">Descripción de la Tarea</label>
                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Escribe los detalles aquí..." required></textarea>
                        </div>
                        
                        <button type="submit" class="btn-custom btn-primary-custom w-100">
                            <i class="bi bi-plus-circle-fill"></i> Crear Tarea
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right Side: Lists Dashboard -->
            <div class="col-lg-8">
                <div class="row g-4">
                    <!-- Pending Tasks List -->
                    <div class="col-12">
                        <div class="glass-card">
                            <div class="px-4 py-3 border-bottom border-secondary border-opacity-25 d-flex justify-content-between align-items-center">
                                <h3 class="fs-5 mb-0 text-white d-flex align-items-center">
                                    <i class="bi bi-hourglass-split me-2 text-warning"></i> Tareas Pendientes
                                </h3>
                                <span class="badge bg-warning text-dark rounded-pill px-3 py-2"><?= $pendingCount ?></span>
                            </div>
                            
                            <div class="task-list">
                                <?php if ($pendingCount === 0): ?>
                                    <div class="empty-state">
                                        <i class="bi bi-check2-all"></i>
                                        <h5>¡No hay tareas pendientes!</h5>
                                        <p class="small text-secondary mb-0">Buen trabajo, estás completamente al día.</p>
                                    </div>
                                <?php else: ?>
                                    <?php foreach ($pendingTasks as $task): ?>
                                        <div class="task-item">
                                            <div>
                                                <div class="task-title text-white"><?= htmlspecialchars($task->getDescription()) ?></div>
                                                <div class="task-meta">
                                                    <i class="bi bi-calendar3"></i> 
                                                    <?= htmlspecialchars($task->getCreatedAt()->format('d/m/Y H:i')) ?>
                                                </div>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <!-- Complete Button -->
                                                <form action="index.php" method="POST" class="m-0">
                                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                                    <input type="hidden" name="action" value="complete">
                                                    <input type="hidden" name="id" value="<?= $task->getId() ?>">
                                                    <button type="submit" class="action-btn action-btn-success" title="Completar tarea">
                                                        <i class="bi bi-check-lg"></i>
                                                    </button>
                                                </form>

                                                <!-- Delete Button -->
                                                <form action="index.php" method="POST" class="m-0" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta tarea?');">
                                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="id" value="<?= $task->getId() ?>">
                                                    <button type="submit" class="action-btn action-btn-danger" title="Eliminar tarea">
                                                        <i class="bi bi-trash3-fill"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Completed Tasks List -->
                    <div class="col-12">
                        <div class="glass-card">
                            <div class="px-4 py-3 border-bottom border-secondary border-opacity-25 d-flex justify-content-between align-items-center">
                                <h3 class="fs-5 mb-0 text-white d-flex align-items-center">
                                    <i class="bi bi-check-circle-fill me-2 text-success"></i> Tareas Completadas
                                </h3>
                                <span class="badge bg-success text-white rounded-pill px-3 py-2"><?= $completedCount ?></span>
                            </div>
                            
                            <div class="task-list">
                                <?php if ($completedCount === 0): ?>
                                    <div class="empty-state">
                                        <i class="bi bi-clipboard"></i>
                                        <h5>Ninguna tarea completada aún</h5>
                                        <p class="small text-secondary mb-0">Completa una tarea pendiente para verla reflejada aquí.</p>
                                    </div>
                                <?php else: ?>
                                    <?php foreach ($completedTasks as $task): ?>
                                        <div class="task-item task-completed">
                                            <div>
                                                <div class="task-title text-secondary"><?= htmlspecialchars($task->getDescription()) ?></div>
                                                <div class="task-meta">
                                                    <i class="bi bi-calendar3"></i> 
                                                    <?= htmlspecialchars($task->getCreatedAt()->format('d/m/Y H:i')) ?>
                                                </div>
                                            </div>
                                            <div>
                                                <!-- Delete Button -->
                                                <form action="index.php" method="POST" class="m-0" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta tarea?');">
                                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="id" value="<?= $task->getId() ?>">
                                                    <button type="submit" class="action-btn action-btn-danger" title="Eliminar tarea">
                                                        <i class="bi bi-trash3-fill"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
