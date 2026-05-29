# TaskStatus Enum

**Date:** 2023-10-27
**Status:** Accepted
**Commit:** [feat: Add TaskStatus enum](https://github.com/johnyse99/TaskForge_PHP-Task-Manager/commits?q=ADR-003)

## Context
The application, TaskForge, requires a clear, explicit, and type-safe mechanism to represent the lifecycle and current state of a task entity. Prior to this, task statuses might have been managed using arbitrary strings or integers, which could lead to inconsistencies, errors due to typos, and lack of clarity in the domain model. A well-defined set of states is fundamental for tracking tasks, filtering them, and implementing business logic based on their status.

## Decision
A new PHP 8.1+ enum, `TaskForge\Domain\TaskStatus`, was created in `src/Domain/TaskStatus.php`. This enum is backed by `string` values, which provides both type safety within the application and human-readable, persistent values suitable for storage in a database or transfer via APIs. The initial set of cases defined are `Pending` and `Completed`, representing the fundamental states of a task. This design centralizes the definition of task states, ensuring consistency across the application.

## Consequences
This decision significantly improves the robustness and maintainability of the application.
*   **Type Safety:** Components interacting with task statuses will now benefit from PHP's type system, preventing the assignment or comparison of invalid status values.
*   **Readability:** Code that uses task statuses will be more explicit and easier to understand due to the descriptive enum cases.
*   **Maintainability:** Adding new task statuses (e.g., `InProgress`, `Deferred`, `Cancelled`) in the future will be straightforward and less error-prone, requiring modification only to the enum itself rather than scattered string checks.
*   **Interaction:** All `Task` entity operations, `TaskRepository` methods, and any service layer logic (e.g., `TaskService`) dealing with task state will now be refactored to utilize this enum. Similarly, API endpoints or UI components responsible for displaying or modifying task states will interact with the enum's string values.
*   **Trade-offs:** This introduces a dependency on PHP 8.1 or higher for the runtime environment. There is also a minor increase in the number of domain files.