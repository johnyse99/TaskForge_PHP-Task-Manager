# User Guide: TaskForge

Welcome to **TaskForge**, a modern, lightweight, and secure task management system designed to organize your day-to-day productivity. This user guide contains everything you need to set up, configure, run, and interact with the application.

---

## 1. System Requirements

To run TaskForge, ensure your environment meets the following requirements:
- **PHP**: Version 8.1 or higher.
- **PHP Extensions**: `pdo`, `pdo_sqlite` (if using SQLite persistence), and `json` (if using JSON fallback).
- **Composer**: Dependency manager for PHP, required for autoloading and running tests.
- **Web Browser**: A modern web browser supporting HTML5, CSS3, and JavaScript (e.g., Google Chrome, Mozilla Firefox, Microsoft Edge, Safari).

---

## 2. Installation and Setup

Follow these steps to deploy and run TaskForge on your local machine:

### Step 1: Install Dependencies
Open your terminal in the TaskForge root directory and run Composer to install package dependencies and generate the class autoloader:
```bash
composer install
```

### Step 2: Configure the Environment
Locate the `.env` file in the root folder. You can customize the settings below:
```ini
# Database Configuration
DB_DRIVER=sqlite                      # Choose 'sqlite' (default) or 'json'
SQLITE_DB_PATH=data/database.sqlite  # Target file for SQLite database
JSON_DB_PATH=data/tasks.json          # Target file for JSON storage
```

### Step 3: Permissions
Ensure that the `data/` directory (or whichever path is configured in your `.env`) has **write permissions** so that the application can create and modify the database files at runtime.

---

## 3. Running the Application

You can quickly run TaskForge using the built-in PHP development server. Run the following command in the root folder:

```bash
php -S localhost:8000
```

Once started, open your web browser and navigate to:
[http://localhost:8000](http://localhost:8000)

---

## 4. Application Dashboard Walkthrough

TaskForge features an interactive, dark glassmorphic dashboard design split into three core zones:

```
+-----------------------------------------------------------------------------+
|  [Logo] TaskForge (PHP Task Manager)                  [SQLITE/JSON BADGE]   |
+-----------------------------------------------------------------------------+
|  [ Total: 4 ]      [ Pending: 3 ]      [ Completed: 1 ]     [ Progress: 25% ]|
+------------------------------------+----------------------------------------+
|                                    |                                        |
|  NUEVA TAREA                       |  TAREAS PENDIENTES                     |
|  +------------------------------+  |  - Task A (Created Date)  [Check] [Bin]|
|  | Write task description...    |  |  - Task B (Created Date)  [Check] [Bin]|
|  +------------------------------+  |                                        |
|  [ Crear Tarea Button ]            |  TAREAS COMPLETADAS                    |
|                                    |  - Task C (Strikethrough)         [Bin]|
|                                    |                                        |
+------------------------------------+----------------------------------------+
```

### 4.1 Header Bar & Active Storage Driver Badge
The header showcases the application brand. A status badge on the top right shows either **SQLite Database** or **JSON Storage**, indicating which persistence mechanism is actively configured in your `.env`.

### 4.2 Statistics Overview Panel
Located at the top of the interface, this card panel gives you a real-time summary of your tasks:
- **Total**: Total tasks created.
- **Pendientes (Pending)**: Tasks waiting to be completed.
- **Completadas (Completed)**: Tasks finished.
- **Progreso (Progress)**: The completion rate percentage shown as a visual metric.

### 4.3 Creating a Task (Nueva Tarea)
1. On the left side of the dashboard, locate the **Nueva Tarea** form.
2. In the text area, type a description of your task (e.g., "Prepare weekly slides").
3. Click the **Crear Tarea** button.
4. If successful, a green confirmation alert appears, and the task list updates immediately.

### 4.4 Managing Tasks (Dashboard Boards)
The right-hand column contains two lists that classify tasks by their state:

- **Tareas Pendientes (Pending Tasks)**: 
  - Displays tasks that require attention, sorted by creation date (newest first).
  - To complete a task, click the **Green Checkmark Button** (`✓`). The task moves to the completed section and the progress updates.
  - To delete a task, click the **Red Trash Icon** (`🗑`). A confirmation alert asks you to confirm before deletion.
  
- **Tareas Completadas (Completed Tasks)**:
  - Displays tasks already completed with a strikethrough styling to represent finished work.
  - You can delete completed tasks by clicking their corresponding **Red Trash Icon**.

### 4.5 Flash System Notifications
Action alerts will appear at the top of the dashboard to notify you of successful actions (e.g., *"Tarea completada exitosamente."*) or error messages if verification failed.

---

## 5. Developer Guide & Tests

### Running Automated Tests
TaskForge comes with a full PHPUnit suite testing the domain models, use cases, and repository adapters. To run the automated tests, execute:

```bash
./vendor/bin/phpunit
```

### Architecture Diagram
TaskForge is built using **Hexagonal Architecture**. To see the system's ports and adapters representation, refer to the diagram located at:
[hexagonal_diagram.png](file:///c:/Users/DEVELOPER/GIT%20REPOSITORY/project-2/docs/architecture/hexagonal_diagram.png)
*(Located in `docs/architecture/hexagonal_diagram.png`)*
