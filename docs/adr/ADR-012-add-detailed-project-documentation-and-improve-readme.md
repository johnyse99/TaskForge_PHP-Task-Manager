# Introduce Comprehensive Project Documentation

**Date:** 2023-10-27
**Status:** Accepted
**Commit:** [docs: Add detailed project documentation and improve README](https://github.com/johnyse99/TaskForge_PHP-Task-Manager/commits?q=ADR-012)

## Context
The TaskForge project, designed to demonstrate clean architecture principles, lacked comprehensive documentation detailing its internal design, user interaction, and technical specifications. While the `README.md` provided a basic overview, it was insufficient for:
1.  Onboarding new developers or contributors to the Hexagonal Architecture and SOLID principles employed.
2.  Guiding end-users through installation, configuration, and feature usage.
3.  Providing in-depth technical insights into persistence mechanisms (SQLite, JSON), security measures, and overall system structure.
4.  Effectively communicating the project's architectural decisions and promoting its educational value.
This gap hindered project understanding, maintainability, and user adoption.

## Decision
A comprehensive documentation strategy has been implemented by introducing a structured `docs/` directory and significantly enhancing the main `README.md`.

The following documentation assets were created or updated:
-   **`README.md` Improvement:**
    -   Enhanced with current project status badges (PHP version, License, Build, Tests).
    -   Sections for Overview, Features, Tech Stack, Installation, Project Structure, Testing, and License were refined for clarity and conciseness.
    -   New "Documentation" section added with explicit links to the detailed guides in the `docs/` directory.
-   **`docs/architecture/hexagonal_diagram.png`:** Added a visual representation of the Hexagonal Architecture (Ports and Adapters pattern) to clearly illustrate the system's modular design and separation of concerns.
-   **`docs/manuals/user_guide.md`:** A detailed user guide covering:
    -   System requirements.
    -   Step-by-step installation and environment setup instructions (including `.env` configuration and permissions).
    -   Running the application with PHP's built-in server.
    -   A comprehensive dashboard walkthrough, explaining UI elements, task creation, and task management.
    -   Instructions for running automated tests.
-   **`docs/specifications/database_design.md`:** A technical document detailing the persistence layer, including:
    -   An overview of the dual-database capability (SQLite and JSON).
    -   SQLite database schema (`tasks` table, DDL, key SQL queries).
    -   JSON flat-file database schema, auto-increment key emulation, and critical concurrency control via file locking (`flock`).
-   **`docs/specifications/technical_specs.md`:** An in-depth specification outlining:
    -   System overview and key design features (SOLID, Hexagonal Architecture, Security-First).
    -   Detailed explanation of the Hexagonal Architecture layers (Domain, Application, Interface, Infrastructure), describing each component's role, dependencies, and responsibilities.
    -   The technology stack and dependencies.
    -   Multi-tiered security controls (CSRF, input validation, XSS prevention, concurrency protection).
    -   A complete project file system structure mapping.

## Consequences
**Positive:**
-   **Improved Understanding:** New developers and users can quickly grasp the project's architecture, functionality, and usage through structured and detailed documentation.
-   **Enhanced Onboarding:** Reduces the learning curve for new team members, accelerating their contribution process.
-   **Clear Architectural Communication:** The Hexagonal Architecture is now explicitly documented and visualized, reinforcing the project's core design principles.
-   **Increased Maintainability:** Detailed specifications aid in future development, debugging, and refactoring efforts by providing clear references for component interactions and data structures.
-   **Better User Experience:** A comprehensive user guide ensures users can install, configure, and effectively utilize the application's features.
-   **Professionalism:** Elevates the overall professionalism and completeness of the project, making it more appealing for collaboration and educational purposes.
-   **Security Awareness:** Clearly outlines implemented security measures, fostering confidence in the application's robustness.

**Negative (Trade-offs):**
-   **Documentation Maintenance Overhead:** An ongoing commitment is required to keep the newly created documentation up-to-date with any future code changes or architectural shifts, potentially leading to documentation rot if neglected.
-   **Initial Time Investment:** Significant effort was invested in creating these detailed documents, which diverted resources temporarily from functional code development.