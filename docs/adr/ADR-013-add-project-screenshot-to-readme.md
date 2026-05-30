# Adding Project Screenshot to README

**Date:** 2023-10-27
**Status:** Accepted
**Commit:** [docs: Add project screenshot to README](https://github.com/johnyse99/TaskForge_PHP-Task-Manager/commits?q=ADR-013)

## Context
The `README.md` serves as the primary introduction to the TaskForge project. While it effectively describes the project's purpose, features, and technical details in text, a visual representation of the application would significantly enhance the initial understanding and engagement for prospective users and contributors. A screenshot provides an immediate visual context of the user interface and overall look and feel, making it easier for visitors to grasp what the application does without needing to install or run it first.

## Decision
The `README.md` file has been updated to incorporate a project screenshot. A new binary image file, `preview-1.png`, was added to the repository. This image is embedded into the `README.md` using standard Markdown image syntax (`![alt text](preview-1.png)`). Additionally, horizontal rule separators (`---`) were introduced around the screenshot and other key sections of the `README.md` to improve visual structure and readability.

## Consequences
This decision primarily impacts the presentation and discoverability of the TaskForge project.
*   **Positive Impact:**
    *   **Enhanced User Experience:** Provides an immediate visual understanding of the application's user interface and functionality, improving the clarity and engagement of the `README.md`.
    *   **Improved First Impression:** Makes the repository more visually appealing and informative for new visitors.
*   **Minor Trade-offs:**
    *   **Increased Repository Size:** The addition of the `preview-1.png` file slightly increases the overall size of the repository. For a single screenshot, this impact is generally negligible.
    *   **No Core Architectural Impact:** This change is purely a documentation and presentation enhancement and does not affect the application's core architecture, code logic, or runtime performance.