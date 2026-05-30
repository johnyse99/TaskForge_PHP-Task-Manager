# Update Preview Image Path in README

**Date:** 2023-10-27
**Status:** Accepted
**Commit:** [docs: Update preview image path](https://github.com/johnyse99/TaskForge_PHP-Task-Manager/commits?q=ADR-017)


## Context
The `README.md` file currently references an incorrect or outdated path for the project's preview image (`preview-1.png`). This results in a broken image link, negatively impacting the visual presentation of the project when viewed on platforms like GitHub. The requirement is to ensure the correct project preview image is displayed to accurately represent the application to visitors.

## Decision
The image path within the `README.md` file has been updated from `![alt text](preview-1.png)` to `![alt text](preview.png)`. This change corrects the asset link, pointing the README to the correct file for the project's visual preview.

## Consequences
This change ensures that the project's main preview image is displayed correctly in the `README.md`, improving the overall presentation and immediate understanding of the project for new visitors. There are no architectural or functional changes to the application code, and no new components or dependencies are introduced. This is purely a documentation improvement.