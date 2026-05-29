# Initial TaskForge Application with Web UI

**Date:** 2023-11-06
**Status:** Accepted
**Commit:** [feat: Implement core TaskForge application with web UI and tests](https://github.com/johnyse99/TaskForge_PHP-Task-Manager/commits?q=ADR-006)

## Context
The project requires the development of a functional task management application, "TaskForge," accessible via a web user interface. This initial implementation must establish the core application structure, enable basic CRUD (Create, Read, Update, Delete) operations for tasks, and provide a user-friendly web interface. Furthermore, the system needs to support configurable data persistence options and ensure the reliability of its core components through automated testing.

## Decision
The core TaskForge application has been implemented, establishing a foundational structure and key functionalities.

1.  **Application Entry Point and Structure (`index.php`)**:
    *   A single entry point (`index.php`) was created to bootstrap the application.
    *   It dynamically selects between `TaskForge\Infrastructure\TaskRepositorySQLite` and `TaskForge\Infrastructure\TaskRepositoryJSON` for data persistence based on the `DB_DRIVER` environment variable (`sqlite` or `json`). This provides flexibility in storage.
    *   Dependencies (`TaskRepository`, `TaskService`, `TaskController`) are instantiated and wired together, following a basic dependency injection pattern.
    *   A global exception handler is in place to catch unhandled errors.

2.  **Web User Interface (`src/Interface/views/index.php`)**:
    *   A comprehensive web UI was developed using Bootstrap 5, custom CSS for a modern "glassmorphism" aesthetic, and Google Fonts.
    *   It provides a dashboard overview displaying task statistics (total, pending, completed tasks, and completion rate).
    *   Users can create new tasks via a dedicated form.
    *   Tasks are displayed in separate lists for "Pending" and "Completed" states.
    *   Action buttons are provided to mark pending tasks as complete or to delete any task.
    *   Flash messages are supported for user feedback (success/error).
    *   CSRF tokens are integrated into forms for basic security.

3.  **Testing Suite (`phpunit.xml`, `tests/*`)**:
    *   `phpunit.xml` was configured to run tests within the `tests` directory.
    *   **Domain Unit Tests (`tests/Domain/TaskTest.php`)**: Validates the `Task` entity's behavior, including creation, description validation, and status transitions.
    *   **Application Service Unit Tests (`tests/Application/TaskServiceTest.php`)**: Tests the `TaskService` business logic (creating, completing, deleting tasks) using mock implementations of the `TaskRepositoryInterface`.
    *   **Infrastructure Integration Tests (`tests/Infrastructure/TaskRepositoryTest.php`)**: Verifies the correct functioning of both `TaskRepositorySQLite` and `TaskRepositoryJSON` by performing CRUD operations against actual storage mechanisms (in-memory SQLite and a temporary JSON file).

## Consequences
*   **Positive Impacts**:
    *   **Functional MVP**: Delivers a complete, albeit basic, task management application with a responsive web UI.
    *   **Layered Architecture**: Establishes a clear separation of concerns (Domain, Application, Infrastructure, Interface), enhancing maintainability, testability, and scalability for future features.
    *   **Flexible Data Storage**: The ability to switch between SQLite and JSON data storage via environment variables offers immediate flexibility and ease of deployment in different environments (e.g., local development with JSON, production with SQLite).
    *   **Robustness through Testing**: The extensive test suite (unit and integration) provides confidence in the core business logic and persistence layers, reducing the risk of regressions and facilitating future development.
    *   **Improved User Experience**: The modern UI design and clear task organization contribute to a positive user experience.
    *   **Basic Security**: CSRF protection is implemented on all forms.

*   **Negative Impacts / Trade-offs**:
    *   **Basic Dependency Injection**: The current `index.php` directly handles dependency resolution, which could become cumbersome for applications with many dependencies. A more sophisticated DI container might be considered in the future.
    *   **UI Logic in View**: The `src/Interface/views/index.php` contains some presentation logic (e.g., task segregation, stats calculation) that, while functional for an MVP, could be extracted into dedicated view models or presenters for cleaner MVC separation in a larger application.
    *   **Simple Error Handling**: The `die()` statement in `index.php` for application errors is basic; a more robust error reporting and user-friendly error page mechanism would be beneficial for production environments.
    *   **Configuration Management**: Database paths are configured via `$_ENV` variables, which is effective but could be expanded with a more centralized configuration management system (e.g., `.env` file loader, configuration object) for complex settings.