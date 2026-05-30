# Technical Specifications: TaskForge

This document describes the technical specifications of **TaskForge**, a lightweight, high-performance, and modular Task Manager application built in PHP 8.x. The project is designed using the **Hexagonal Architecture (Ports and Adapters)** pattern to ensure strict separation of concerns, decoupling core business logic from external frameworks, user interfaces, and database configurations.

---

## 1. System Overview

TaskForge allows users to manage a daily dashboard of tasks. It supports creating tasks, viewing pending and completed tasks, marking tasks as completed, and deleting tasks. 

Key design features:
- **SOLID Principles**: Focused on single responsibilities, interface segregation, and dependency inversion.
- **Hexagonal Architecture**: Business logic is fully encapsulated and independent of the delivery mechanism (Web UI) and data store (SQLite database or JSON flat-file).
- **Security-First Focus**: Incorporates cross-site request forgery (CSRF) protection, input sanitation, and cross-site scripting (XSS) prevention.
- **Interactive, Premium UI**: Implements a glassmorphic dark-mode interface built with Bootstrap 5, custom CSS gradients, Google Fonts, and micro-animations.

---

## 2. Architecture & Design Patterns

The project follows a **Hexagonal Architecture** layout, consisting of three main concentric layers: the Domain (core), the Application Layer, and the external Interface and Infrastructure Adapters.

```
       +-------------------------------------------------------------+
       |                         ADAPTERS                            |
       |                                                             |
       |  +-------------------------------------------------------+  |
       |  |                     APPLICATION                       |  |
       |  |                                                       |  |
       |  |  +-------------------------------------------------+  |  |
       |  |  |                     DOMAIN                      |  |  |
       |  |  |                                                 |  |  |
       |  |  |   [Task Entity]   --->   [TaskStatus Enum]      |  |  |
       |  |  |         |                                       |  |  |
       |  |  |         v                                       |  |  |
       |  |  |   [TaskRepositoryInterface] (Port)              |  |  |
       |  |  +---------+---------------------------------------+  |  |
       |  |            ^                                          |  |
       |  |            | (injects)                                |  |
       |  |      [TaskService] (Use Cases)                        |  |
       |  +------------+------------------------------------------+  |
       |               ^                                             |
       |               | (calls)                                     |
       |      +--------+--------+            +--------+--------+     |
       |      |    INTERFACE    |            | INFRASTRUCTURE  |     |
       |      |  (UI Adapter)   |            | (Db Adapter)    |     |
       |      |                 |            |                 |     |
       |      | TaskController  |            | TaskRepoSQLite  |     |
       |      | views/index.php |            | TaskRepoJSON    |     |
       |      +-----------------+            +-----------------+     |
       +-------------------------------------------------------------+
```

### 2.1 Domain Layer (Core)
The domain layer represents the core business logic of the system. It has zero external dependencies and does not know about databases or HTTP.

- **`Task` Entity (`TaskForge\Domain\Task`)**: The central domain model.
  - Represents a single task with private properties: `id` (nullable int), `description` (string), `status` (`TaskStatus`), and `createdAt` (`DateTimeImmutable`).
  - Enforces invariant validation: the task description cannot be empty (throwing an `InvalidArgumentException`).
  - Exposes the business method `complete()` to change status to `TaskStatus::Completed`.
- **`TaskStatus` Enum (`TaskForge\Domain\TaskStatus`)**:
  - A backed string enum (`pending` and `completed`) providing type safety for task states.
- **`TaskRepositoryInterface` Port (`TaskForge\Domain\TaskRepositoryInterface`)**:
  - Defines the storage contract.
  - Declares methods: `save(Task $task)`, `findAll()`, `findById(int $id)`, and `delete(int $id)`.

### 2.2 Application Layer
The application layer coordinates the execution of tasks and use cases. It sits on top of the domain layer and interacts with the domain via its entities and repository interfaces.

- **`TaskService` (`TaskForge\Application\TaskService`)**:
  - Implements key use cases: `createTask(string $description)`, `listAllTasks()`, `completeTask(int $id)`, and `deleteTask(int $id)`.
  - Injects `TaskRepositoryInterface` via its constructor (Dependency Inversion), keeping it decoupled from database choices.

### 2.3 Interface Layer (Primary Adapters)
Primary adapters drive the application by receiving user input, executing use cases, and presenting views.

- **`TaskController` (`TaskForge\Interface\TaskController`)**:
  - Processes incoming requests (`GET` and `POST`).
  - Routes operations (`create`, `complete`, `delete`).
  - Performs validation (CSRF token verification and input check) and session flash message orchestration.
  - Requires the Bootstrap-based view template.
- **Views (`TaskForge\Interface\views\index.php`)**:
  - The presentation template.
  - Implements a responsive, dark glassmorphic design system using Tailwind-style tailored colors, smooth gradients, statistical cards, custom action buttons, empty states, and dynamic status-aware lists.

### 2.4 Infrastructure Layer (Secondary Adapters)
Secondary adapters are driven by the application. They provide implementations for external resources like databases or files.

- **`TaskRepositorySQLite` (`TaskForge\Infrastructure\TaskRepositorySQLite`)**:
  - Implements `TaskRepositoryInterface` using PDO and SQLite.
  - On instantiation, automatically triggers schema setup if the table `tasks` doesn't exist.
  - Handles bidirectional data transformation between SQLite database records and the Domain `Task` object.
- **`TaskRepositoryJSON` (`TaskForge\Infrastructure\TaskRepositoryJSON`)**:
  - Implements `TaskRepositoryInterface` using standard JSON files for environments without SQLite.
  - Incorporates file locking (`flock` with `LOCK_EX`) to prevent data corruption during concurrent write/update operations.

---

## 3. Technology Stack & Dependencies

- **Runtime Environment**: PHP 8.1+
- **Data Persistence Drivers**: 
  - `PDO` SQLite driver (default)
  - Raw JSON flat-file storage (fallback)
- **UI Frameworks & Styling**:
  - Bootstrap 5.3.2 (responsive layout grids, tables, badges, utility wrappers)
  - Bootstrap Icons (system iconography)
  - Google Fonts (Outfit for headers; Inter for body typography)
- **Package Management**: Composer (managing autoloader and dev dependencies)
- **Testing Framework**: PHPUnit 10.x for automated testing

---

## 4. Security Controls

TaskForge employs a multi-tiered security approach to safeguard the application and its data integrity:

1. **CSRF Protection**: 
   - A cryptographically secure CSRF token is generated and stored in the session (`$_SESSION['csrf_token']`) upon bootstrap.
   - All mutative operations (`create`, `complete`, `delete`) submitted via POST forms are verified against this session token by `TaskController`.
2. **Input Validation**:
   - The UI controller checks if inputs are empty or invalid before processing.
   - The domain `Task` entity implements constructor-level guard clauses, throwing exceptions if descriptions consist of empty whitespace.
3. **Cross-Site Scripting (XSS) Prevention**:
   - Raw output formatting is escaped using PHP's `htmlspecialchars()` function inside the view template before rendering on the page.
4. **Concurrency Protection**:
   - The JSON adapter implements file-locking mechanisms (`flock`) to ensure write safety during multi-threaded requests.

---

## 5. File System Structure

```
taskforge-project/
├── .env                          # Configuration environment variables
├── bootstrap.php                 # App bootstrap, session, autoloader, and env loader
├── composer.json                 # Composer dependencies and autoloading definitions
├── index.php                     # Application entry point & dependency wire-up
├── phpunit.xml                   # Test runner configuration
├── data/                         # Persistent storage folder (SQLite / JSON)
│   ├── database.sqlite           # SQLite file (auto-generated)
│   └── tasks.json                # JSON fallback file (auto-generated)
├── docs/                         # Documentation
│   ├── adr/                      # Architectural Decision Records (ADRs)
│   ├── architecture/             # Architectural diagrams
│   │   └── hexagonal_diagram.png # Hexagonal Ports & Adapters diagram
│   ├── manuals/                  # User and operator manuals
│   │   └── user_guide.md         # End-user setup and usage instructions
│   └── specifications/           # Technical specifications
│       ├── database_design.md    # Database structure & locking specifications
│       └── technical_specs.md    # Current file
├── src/                          # Application source code
│   ├── Application/
│   │   └── TaskService.php       # Application Use Cases
│   ├── Domain/
│   │   ├── Task.php              # Domain Entity (Task)
│   │   ├── TaskRepositoryInterface.php # Repository Port (Interface)
│   │   └── TaskStatus.php        # TaskStatus Value Object (Enum)
│   ├── Infrastructure/
│   │   ├── TaskRepositoryJSON.php # Secondary Adapter (JSON File Storage)
│   │   └── TaskRepositorySQLite.php # Secondary Adapter (SQLite Database)
│   └── Interface/
│       ├── TaskController.php    # Primary Adapter (HTTP Controller)
│       └── views/
│           └── index.php         # Render View Template (HTML5/Bootstrap)
└── tests/                        # Suite of automated tests
    ├── Application/
    │   └── TaskServiceTest.php   # Service layer tests
    ├── Domain/
    │   └── TaskTest.php          # Domain model unit tests
    └── Infrastructure/
        └── TaskRepositoryTest.php # Adapter and persistence tests
```
