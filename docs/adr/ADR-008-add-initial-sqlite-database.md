# Initial SQLite Database File

**Date:** 2023-10-27
**Status:** Accepted
**Commit:** [chore: Add initial SQLite database](https://github.com/johnyse99/TaskForge_PHP-Task-Manager/commits?q=ADR-008)

## Context
A fundamental requirement for most modern web applications, including a task manager, is the persistent storage of application data. This data typically includes tasks, users, categories, and their associated attributes. Without a mechanism for persistence, all application state would be lost between requests or server restarts, rendering the application non-functional for long-term use. To address this, a database system is needed to reliably store and retrieve structured data.

## Decision
An initial SQLite database file named `database.sqlite` has been created and added to the `data/` directory of the project. This decision establishes SQLite as the chosen relational database management system for the application's data persistence layer. The file currently represents an empty or minimally initialized database, providing the foundation upon which future schema definitions (tables, columns, indexes) will be built using migrations or ORM tools. This file-based approach simplifies initial setup and development.

## Consequences
This decision introduces persistent storage capabilities to the application, allowing for the saving and retrieval of application data across sessions.
*   **Positive Impacts:**
    *   Enables the application to maintain state and data, which is crucial for a task manager.
    *   Simplifies local development and testing, as SQLite is a serverless, file-based database with minimal setup overhead.
    *   Avoids the need for a separate database server during development, streamlining the developer workflow.
*   **Negative Impacts/Trade-offs:**
    *   The `database.sqlite` file, if directly committed and frequently modified with data, can lead to merge conflicts in version control. Best practice dictates that the initial file might be empty or a schema placeholder, with actual data changes handled via migrations.
    *   While suitable for development and small-scale applications, SQLite may not offer the same level of concurrency or scalability as client-server databases (e.g., MySQL, PostgreSQL) for high-traffic production environments. This might necessitate a migration to a different database system in the future as the application scales.
    *   Requires a data access layer (e.g., an ORM or direct PDO calls) within the application to interact with this database file, which will be developed in subsequent features.