# Initial Application Setup and Task CRUD Implementation

**Date:** 2024-07-30
**Status:** Accepted
**Commit:** [feat: Add initial application setup and task CRUD](https://github.com/johnyse99/TaskForge_PHP-Task-Manager/commits?q=ADR-005)

## Context
The project requires an initial foundational setup to allow for basic web application functionality and the core domain feature: managing tasks. This includes setting up the environment, handling HTTP requests, and persisting task data. Specifically, the application needs:
*   A mechanism to initialize common application services (sessions, error reporting, autoloader).
*   A way to load environment-specific configurations.
*   Basic security measures, such as CSRF protection.
*   A user interface entry point for interacting with tasks.
*   A simple persistence mechanism for task data, supporting Create, Read, Update, and Delete (CRUD) operations for a `Task` entity.

## Decision
1.  **Application Bootstrap (`bootstrap.php`):** A `bootstrap.php` file was created to centralize application initialization. This file is responsible for:
    *   Starting PHP sessions.
    *   Enabling detailed error reporting.
    *   Loading Composer's autoloader.
    *   Implementing a simple `.env` file loader to manage environment variables (e.g., database paths, configuration settings).
    *   Generating and storing a CSRF token in the session for basic security.

2.  **Task Data Persistence (`TaskRepositoryJSON`):** The `TaskRepositoryJSON` class was implemented, adhering to the `TaskRepositoryInterface` (implied by its methods) to manage the persistence of `Task` entities. This repository uses a JSON file as its storage mechanism. Key features include:
    *   Ensuring the JSON data file and its directory exist.
    *   Loading and saving task data from/to the JSON file.
    *   Generating unique IDs for new tasks.
    *   Implementing CRUD operations (`save`, `findAll`, `findById`, `delete`) for `Task` objects.
    *   Utilizing file locking (`flock`) for basic concurrency protection during file writes.

3.  **Task User Interface & Request Handling (`TaskController`):** The `TaskController` class was introduced to handle incoming HTTP requests related to task management. This controller:
    *   Takes a `TaskService` dependency (implying the application will have a service layer for business logic).
    *   Dispatches actions based on the HTTP method (`GET` for listing tasks, `POST` for create/complete/delete).
    *   Performs CSRF token verification for all `POST` requests.
    *   Validates incoming request data (e.g., task description, ID).
    *   Delegates business operations (create, complete, delete, list) to the injected `TaskService`.
    *   Manages flash messages (success/error) in the session and redirects the user after POST operations.
    *   Loads a specific view file (`__DIR__ . '/views/index.php'`) to render the task list.

## Consequences
*   **Positive:**
    *   **Rapid Development:** Provides a quick and functional starting point for the application, allowing immediate development of task-related features.
    *   **Simple Persistence:** The JSON file-based repository is extremely easy to set up and requires no external database, ideal for initial development or small-scale applications.
    *   **Basic Structure:** Introduces clear architectural layers (bootstrap, interface/controller, infrastructure/repository) even at this early stage, promoting maintainability.
    *   **Initial Security:** CSRF protection is included from the outset, addressing a common web vulnerability.
    *   **Configurability:** The custom `.env` loader allows for easy environment-specific configuration management without code changes.

*   **Negative / Trade-offs:**
    *   **Scalability Limitations (JSON Repository):** The `TaskRepositoryJSON` is not suitable for high-traffic applications or large datasets due to potential performance bottlenecks with file I/O, lack of true transactional integrity, and limited concurrency provided by `flock`.
    *   **Tight Coupling (Controller):** The `TaskController` directly interacts with superglobals (`$_POST`, `$_SERVER`, `$_SESSION`) and performs direct HTTP redirects and view loading, making it less reusable and harder to test in isolation.
    *   **Custom Environment Loader:** The custom `loadEnv` function is basic and may lack advanced features or robustness of established libraries (e.g., `vlucas/phpdotenv`).
    *   **No Routing Component:** The controller's request handling implies a very simple (or absent) routing mechanism, which could lead to a monolithic `index.php` file if more complex routing is needed in the future.
    *   **Basic Error Handling:** Error messages are general and primarily handled via redirects and flash messages, which might not be sufficient for a more robust application or API.
    *   **View Layer Dependency:** The `TaskController` explicitly includes a view file (`index.php`), coupling it directly to a specific presentation layer without an abstraction for templating or view rendering.