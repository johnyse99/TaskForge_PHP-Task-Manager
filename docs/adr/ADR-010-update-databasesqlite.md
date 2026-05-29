# Database File Update: `database.sqlite`

**Date:** 2023-10-27
**Status:** Accepted
**Commit:** [chore: Update database.sqlite](https://github.com/johnyse99/TaskForge_PHP-Task-Manager/commits?q=ADR-010)


## Context
The `TaskForge_PHP-Task-Manager` application relies on a SQLite database file (`data/database.sqlite`) for all its data persistence, including schema definition and application data. As the application evolves with new features or bug fixes, it often necessitates changes to the underlying database schema (e.g., new tables, columns, or constraints) or updates to initial data. This particular commit reflects the integration of such changes, ensuring the database state aligns with current application requirements for development and testing environments.

## Decision
The existing binary file `data/database.sqlite` was updated by replacing it with a new version. This action incorporates modifications to the database's schema (e.g., structural changes like adding tables or columns) and/or updates to the data initially populated within the database. The new database file is committed directly to the repository, establishing the new required baseline for the application's data layer.

## Consequences
*   **Positive**:
    *   Ensures that all developers and CI/CD environments automatically have the most current required database schema and initial data, simplifying the setup process for new contributors and maintaining consistency across development environments.
    *   Provides a straightforward method for embedding a pre-configured database state directly within the repository, enabling rapid application startup without manual database setup or migration steps.
*   **Negative**:
    *   The specific, granular changes (e.g., exact DDL or DML statements) introduced by this update are not transparently visible through standard version control diffs due to the binary nature of the `database.sqlite` file. This makes code reviews of database schema evolution challenging without external SQLite introspection tools.
    *   Merge conflicts involving `database.sqlite` can be difficult to resolve manually, as they pertain to binary data.
    *   This approach, while simple, offers less explicit control over schema versioning and migration history compared to using dedicated migration scripts, making it less suitable for complex projects or production environments requiring strict database evolution management.