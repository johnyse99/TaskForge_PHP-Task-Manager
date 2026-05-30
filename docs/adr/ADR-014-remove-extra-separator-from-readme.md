# Documentation Readability Enhancement: README Separator Removal

**Date:** 2023-10-27
**Status:** Accepted
**Commit:** [docs: remove extra separator from README](https://github.com/johnyse99/TaskForge_PHP-Task-Manager/commits?q=ADR-014)


## Context
The project's primary `README.md` file is crucial for new users and contributors to quickly understand TaskForge. It was identified that the README contained an extra separator (`---`) immediately following the initial project description and preceding the visual preview image. This redundant visual element introduced unnecessary clutter, subtly diminishing the document's overall aesthetic and readability. The underlying requirement is to maintain high-quality, clean, and easily digestible documentation that reflects a professional standard.

## Decision
It was decided to remove the superfluous `---` separator from the `README.md` file. Specifically, the separator located between the introductory text describing TaskForge and the `---` separator preceding the `preview-1.png` image was targeted for removal. This action streamlines the document's layout and improves the flow of information by eliminating an unnecessary visual break.

## Consequences
*   **Positive:** The `README.md` file now presents a cleaner, more streamlined appearance. This enhances the overall readability and professional appeal of the project's introduction.
*   **Impact on System:** This decision has no direct impact on the runtime behavior, functionality, or performance of the TaskForge application itself, as it is purely a documentation change.
*   **Trade-offs:** No negative trade-offs are associated with this decision. It is a refinement that brings only positive improvements to the project's documentation quality.