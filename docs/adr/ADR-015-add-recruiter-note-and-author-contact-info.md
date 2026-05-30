# README Enhancement for Recruitment and Author Contact

**Date:** YYYY-MM-DD
**Status:** Accepted
**Commit:** [docs: Add recruiter note and author contact info](https://github.com/johnyse99/TaskForge_PHP-Task-Manager/commits?q=ADR-015)


## Context
The project's public face, primarily the `README.md` file, needs to effectively communicate its value and the author's technical capabilities to potential employers and recruiters. It is also essential to provide clear and accessible contact information for the author to facilitate professional inquiries. This requirement stems from the need to leverage the project as a professional portfolio piece.

## Decision
The `README.md` file was updated to include two new sections:
1.  **Note for recruiters:** A dedicated section was added to highlight the project's demonstration of key architectural principles, including transactional integrity, clean architecture, and resilience, thereby showcasing the author's expertise in designing and implementing complex, professional-grade systems.
2.  **Author and Contact Information:** The author's name (JUAN S.) and a direct contact link (GitHub profile: `https://github.com/johnyse99`) were added to provide easy access for interested parties.

This decision enhances the project's utility as a professional showcase without altering any core system functionality.

## Consequences
This change has no direct impact on the system's runtime functionality or internal architecture.
**Positive:**
*   **Improved Communication:** Clearly articulates the project's architectural merits to a target audience (recruiters), enhancing its value as a portfolio piece.
*   **Increased Accessibility:** Provides direct and easy-to-find contact information for the author, facilitating professional networking and job opportunities.
*   **Clarity:** Reinforces the author's technical skills and project's quality standards.

**Trade-offs:**
*   Adds a small amount of additional content to the `README.md` file, which is negligible in terms of file size or readability impact.
*   No new dependencies or integration points are introduced.