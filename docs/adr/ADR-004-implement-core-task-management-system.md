# Implement Core Task Management System

**Date:** 2024-07-30
**Status:** Accepted
**Commit:** [feat: Implement core task management system](https://github.com/johnyse99/TaskForge_PHP-Task-Manager/commits?q=ADR-004)

## Context
The primary requirement for the TaskForge application is to provide robust task management capabilities. This includes the ability to create new tasks, list all existing tasks, mark tasks as complete, and delete tasks. To ensure a maintainable, scalable, and testable system, a structured architectural approach is needed that separates domain logic from application services and infrastructure concerns. This foundational system will form the core of the application's functionality.

## Decision
We have decided to implement the core task management system following a layered architectural pattern, specifically leveraging principles of Domain-Driven Design (DDD).

The following key components have been created:

1.  **`TaskForge\Domain\Task`**: This is the central domain entity representing a task. It encapsulates the task's properties (`id`, `description`, `status`, `createdAt`) and core business logic, such as marking itself as `complete()` and validating its `description` to prevent empty values. It utilizes the `TaskStatus` enum.
2.  **`TaskForge\Domain\TaskStatus`**: A PHP enum that defines the possible states a task can be in (e.g., `Pending`, `Completed`). This provides type safety and clarity for task statuses.
3.  **`TaskForge\Domain\TaskRepositoryInterface`**: An interface defining the contract for persistence operations related to `Task` entities (e.g., `save`, `findAll`, `findById`, `delete`). This abstracts the data storage mechanism from the domain and application layers.
4.  **`TaskForge\Application\TaskService`**: An application service that orchestrates domain operations. It provides an API for use cases such as `createTask`, `listAllTasks`, `completeTask`, and `deleteTask`. It depends on the `TaskRepositoryInterface` to perform data operations, ensuring that business logic is separated from direct database interaction.
5.  **`TaskForge\Infrastructure\TaskRepositorySQLite`**: A concrete implementation of the `TaskRepositoryInterface` that uses SQLite as the persistent storage. This class handles database connection (via PDO), SQL queries for CRUD operations, and mapping between `Task` objects and database rows. It also includes an `initializeSchema` method to create the `tasks` table if it doesn't exist.

## Consequences
**Positive:**

*   **Clear Separation of Concerns:** The architecture clearly delineates responsibilities between Domain (business logic), Application (use cases), and Infrastructure (persistence, external services), enhancing maintainability and understandability.
*   **Testability:** The use of `TaskRepositoryInterface` allows for easy mocking of the repository in application service tests, making unit testing of `TaskService` straightforward without needing a real database. The `Task` entity's logic is also independently testable.
*   **Flexibility and Extensibility:** The repository interface allows for easy swapping of persistence mechanisms (e.g., switching from SQLite to MySQL or a different ORM) without altering the application or domain layers. New task-related features can be added to `TaskService` or as new domain behaviors on `Task`.
*   **Domain Logic Encapsulation:** Business rules (e.g., task description validation, completing a task) are enforced within the `Task` entity itself, preventing an anemic domain model.
*   **Robustness:** Input validation (e.g., non-empty task description) is handled at the domain entity level, ensuring data integrity.

**Trade-offs/Considerations:**

*   **Initial Complexity:** The layered approach introduces more classes and interfaces compared to a simpler, monolithic structure, requiring a higher initial development effort.
*   **Dependency Injection:** Proper functioning requires a dependency injection container to provide the `TaskRepositoryInterface` implementation to the `TaskService`, which is not explicitly shown in the diff but is a necessary component for this design.
*   **Schema Management:** The `TaskRepositorySQLite` includes schema initialization logic. For larger applications, this might evolve into a dedicated database migration system to manage schema changes more robustly.
*   **`setId` on Task:** The `setId` method on the `Task` entity is public, which is necessary for the repository to set the ID upon creation. However, in some strict DDD interpretations, entities might be designed with immutable IDs or ID setting restricted to constructors/factory methods. This approach is practical for auto-incrementing IDs.