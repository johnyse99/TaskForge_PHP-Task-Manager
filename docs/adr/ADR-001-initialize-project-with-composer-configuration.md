# Establish Project Composer Configuration

**Date:** 2023-10-27
**Status:** Accepted
**Commit:** [feat: Initialize project with Composer configuration](https://github.com/johnyse99/TaskForge_PHP-Task-Manager/commits?q=ADR-001)


## Context
The project aims to develop a "Mini Task Manager in PHP using Hexagonal Architecture." To build a modern PHP application that adheres to community best practices, effectively manages external libraries, and provides a structured way to load classes, a robust dependency management and autoloading system is fundamental. This is a critical first step for project organization, maintainability, and facilitating future development and collaboration.

## Decision
A `composer.json` file was created at the project root to establish the foundational Composer configuration. This file defines:
-   `name`: `taskforge/task-manager` to uniquely identify the project as a Composer package.
-   `description`: "Mini Task Manager in PHP using Hexagonal Architecture" providing a concise overview.
-   `require`: Specifies production dependencies, initially enforcing `php: ">=8.1"` to ensure compatibility with modern PHP features.
-   `require-dev`: Specifies development dependencies, initially including `phpunit/phpunit: "^10.0"` to set up a robust testing framework from the start.
-   `autoload`: Configures PSR-4 autoloading, mapping the `TaskForge\` namespace to the `src/` directory, which standardizes class loading within the application.

## Consequences
*   **Positive:**
    *   **Dependency Management:** Enables easy declaration, installation, and updating of both production and development project dependencies.
    *   **Standardized Autoloading:** Adopts PSR-4, ensuring consistent class loading and promoting a clear, organized project structure (e.g., `src/TaskForge/Domain/Task.php`).
    *   **Development Workflow:** Facilitates the quick setup of development tools like PHPUnit, integrating testing as an immediate capability.
    *   **Project Metadata:** Provides essential project information for developers, contributing to easier onboarding and overall project understanding.
*   **Trade-offs:**
    *   **Composer Dependency:** Requires Composer to be installed in both development and deployment environments to manage and install project dependencies.
    *   **Initial Setup Overhead:** While minimal, it introduces a necessary configuration file and an initial setup step for any new developer or environment.