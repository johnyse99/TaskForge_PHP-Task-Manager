# Architecture Decision Records (ADRs)

This is a navigable visual index of all architectural decision records documented for the project. For a fully interactive, styled experience with live search, filters, and dynamic previews, open [0000-index.html](0000-index.html) in your browser.

<div style="display: flex; gap: 16px; margin-bottom: 32px; flex-wrap: wrap;">
  <div style="flex: 1; min-width: 120px; padding: 16px; background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
    <div style="font-size: 28px; font-weight: 800; color: #0f172a; line-height: 1;">5</div>
    <div style="font-size: 11px; color: #64748b; text-transform: uppercase; font-weight: 700; margin-top: 8px; letter-spacing: 0.5px;">Total Records</div>
  </div>
  <div style="flex: 1; min-width: 120px; padding: 16px; background-color: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 8px; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
    <div style="font-size: 28px; font-weight: 800; color: #047857; line-height: 1;">5</div>
    <div style="font-size: 11px; color: #059669; text-transform: uppercase; font-weight: 700; margin-top: 8px; letter-spacing: 0.5px;">Accepted</div>
  </div>
  <div style="flex: 1; min-width: 120px; padding: 16px; background-color: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
    <div style="font-size: 28px; font-weight: 800; color: #1d4ed8; line-height: 1;">0</div>
    <div style="font-size: 11px; color: #2563eb; text-transform: uppercase; font-weight: 700; margin-top: 8px; letter-spacing: 0.5px;">Proposed</div>
  </div>
</div>

<table width="100%" style="border-collapse: collapse; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
  <thead>
    <tr style="background-color: #f8fafc; border-bottom: 2px solid #e2e8f0;">
      <th align="left" style="padding: 14px 18px; font-weight: 600; color: #475569; font-size: 13px; border-bottom: 2px solid #e2e8f0;">ID</th>
      <th align="left" style="padding: 14px 18px; font-weight: 600; color: #475569; font-size: 13px; border-bottom: 2px solid #e2e8f0; white-space: nowrap;">Date</th>
      <th align="left" style="padding: 14px 18px; font-weight: 600; color: #475569; font-size: 13px; border-bottom: 2px solid #e2e8f0;">Status</th>
      <th align="left" style="padding: 14px 18px; font-weight: 600; color: #475569; font-size: 13px; border-bottom: 2px solid #e2e8f0;">Title</th>
      <th align="left" style="padding: 14px 18px; font-weight: 600; color: #475569; font-size: 13px; border-bottom: 2px solid #e2e8f0;">Commit Reference</th>
    </tr>
  </thead>
  <tbody>
    <tr style="background-color: #ffffff; border-bottom: 1px solid #f1f5f9;">
      <td style="padding: 14px 18px; border-bottom: 1px solid #f1f5f9; white-space: nowrap;"><a href="ADR-001-initialize-project-with-composer-configuration.md" style="color: #2563eb; text-decoration: none; font-weight: 700; font-family: SFMono-Regular, Consolas, 'Liberation Mono', Menlo, monospace;">ADR-001</a></td>
      <td style="padding: 14px 18px; font-size: 13px; color: #64748b; border-bottom: 1px solid #f1f5f9; white-space: nowrap;">2023-10-27</td>
      <td style="padding: 14px 18px; border-bottom: 1px solid #f1f5f9; white-space: nowrap;"><span style="background-color: #ecfdf5; color: #047857; border-radius: 9999px; padding: 4px 12px; font-weight: 600; font-size: 11px; display: inline-block; text-transform: uppercase; letter-spacing: 0.5px; border: 1px solid opacity 0.1;">Accepted</span></td>
      <td style="padding: 14px 18px; font-size: 14px; font-weight: 500; color: #1e293b; border-bottom: 1px solid #f1f5f9;">Establish Project Composer Configuration</td>
      <td style="padding: 14px 18px; font-size: 13px; border-bottom: 1px solid #f1f5f9;"><a href="https://github.com/johnyse99/TaskForge_PHP-Task-Manager/commits?q=ADR-001" style="color: #2563eb; text-decoration: none; font-weight: 600;">feat: Initialize project with Composer configuration</a></td>
    </tr>
    <tr style="background-color: #f8fafc; border-bottom: 1px solid #f1f5f9;">
      <td style="padding: 14px 18px; border-bottom: 1px solid #f1f5f9; white-space: nowrap;"><a href="ADR-003-add-taskstatus-enum.md" style="color: #2563eb; text-decoration: none; font-weight: 700; font-family: SFMono-Regular, Consolas, 'Liberation Mono', Menlo, monospace;">ADR-003</a></td>
      <td style="padding: 14px 18px; font-size: 13px; color: #64748b; border-bottom: 1px solid #f1f5f9; white-space: nowrap;">2023-10-27</td>
      <td style="padding: 14px 18px; border-bottom: 1px solid #f1f5f9; white-space: nowrap;"><span style="background-color: #ecfdf5; color: #047857; border-radius: 9999px; padding: 4px 12px; font-weight: 600; font-size: 11px; display: inline-block; text-transform: uppercase; letter-spacing: 0.5px; border: 1px solid opacity 0.1;">Accepted</span></td>
      <td style="padding: 14px 18px; font-size: 14px; font-weight: 500; color: #1e293b; border-bottom: 1px solid #f1f5f9;">TaskStatus Enum</td>
      <td style="padding: 14px 18px; font-size: 13px; border-bottom: 1px solid #f1f5f9;"><a href="https://github.com/johnyse99/TaskForge_PHP-Task-Manager/commits?q=ADR-003" style="color: #2563eb; text-decoration: none; font-weight: 600;">feat: Add TaskStatus enum</a></td>
    </tr>
    <tr style="background-color: #ffffff; border-bottom: 1px solid #f1f5f9;">
      <td style="padding: 14px 18px; border-bottom: 1px solid #f1f5f9; white-space: nowrap;"><a href="ADR-004-implement-core-task-management-system.md" style="color: #2563eb; text-decoration: none; font-weight: 700; font-family: SFMono-Regular, Consolas, 'Liberation Mono', Menlo, monospace;">ADR-004</a></td>
      <td style="padding: 14px 18px; font-size: 13px; color: #64748b; border-bottom: 1px solid #f1f5f9; white-space: nowrap;">2024-07-30</td>
      <td style="padding: 14px 18px; border-bottom: 1px solid #f1f5f9; white-space: nowrap;"><span style="background-color: #ecfdf5; color: #047857; border-radius: 9999px; padding: 4px 12px; font-weight: 600; font-size: 11px; display: inline-block; text-transform: uppercase; letter-spacing: 0.5px; border: 1px solid opacity 0.1;">Accepted</span></td>
      <td style="padding: 14px 18px; font-size: 14px; font-weight: 500; color: #1e293b; border-bottom: 1px solid #f1f5f9;">Implement Core Task Management System</td>
      <td style="padding: 14px 18px; font-size: 13px; border-bottom: 1px solid #f1f5f9;"><a href="https://github.com/johnyse99/TaskForge_PHP-Task-Manager/commits?q=ADR-004" style="color: #2563eb; text-decoration: none; font-weight: 600;">feat: Implement core task management system</a></td>
    </tr>
    <tr style="background-color: #f8fafc; border-bottom: 1px solid #f1f5f9;">
      <td style="padding: 14px 18px; border-bottom: 1px solid #f1f5f9; white-space: nowrap;"><a href="ADR-005-add-initial-application-setup-and-task-crud.md" style="color: #2563eb; text-decoration: none; font-weight: 700; font-family: SFMono-Regular, Consolas, 'Liberation Mono', Menlo, monospace;">ADR-005</a></td>
      <td style="padding: 14px 18px; font-size: 13px; color: #64748b; border-bottom: 1px solid #f1f5f9; white-space: nowrap;">2024-07-30</td>
      <td style="padding: 14px 18px; border-bottom: 1px solid #f1f5f9; white-space: nowrap;"><span style="background-color: #ecfdf5; color: #047857; border-radius: 9999px; padding: 4px 12px; font-weight: 600; font-size: 11px; display: inline-block; text-transform: uppercase; letter-spacing: 0.5px; border: 1px solid opacity 0.1;">Accepted</span></td>
      <td style="padding: 14px 18px; font-size: 14px; font-weight: 500; color: #1e293b; border-bottom: 1px solid #f1f5f9;">Initial Application Setup and Task CRUD Implementation</td>
      <td style="padding: 14px 18px; font-size: 13px; border-bottom: 1px solid #f1f5f9;"><a href="https://github.com/johnyse99/TaskForge_PHP-Task-Manager/commits?q=ADR-005" style="color: #2563eb; text-decoration: none; font-weight: 600;">feat: Add initial application setup and task CRUD</a></td>
    </tr>
    <tr style="background-color: #ffffff; border-bottom: 1px solid #f1f5f9;">
      <td style="padding: 14px 18px; border-bottom: 1px solid #f1f5f9; white-space: nowrap;"><a href="ADR-006-implement-core-taskforge-application-with-web-ui-and-tests.md" style="color: #2563eb; text-decoration: none; font-weight: 700; font-family: SFMono-Regular, Consolas, 'Liberation Mono', Menlo, monospace;">ADR-006</a></td>
      <td style="padding: 14px 18px; font-size: 13px; color: #64748b; border-bottom: 1px solid #f1f5f9; white-space: nowrap;">2023-11-06</td>
      <td style="padding: 14px 18px; border-bottom: 1px solid #f1f5f9; white-space: nowrap;"><span style="background-color: #ecfdf5; color: #047857; border-radius: 9999px; padding: 4px 12px; font-weight: 600; font-size: 11px; display: inline-block; text-transform: uppercase; letter-spacing: 0.5px; border: 1px solid opacity 0.1;">Accepted</span></td>
      <td style="padding: 14px 18px; font-size: 14px; font-weight: 500; color: #1e293b; border-bottom: 1px solid #f1f5f9;">Initial TaskForge Application with Web UI</td>
      <td style="padding: 14px 18px; font-size: 13px; border-bottom: 1px solid #f1f5f9;"><a href="https://github.com/johnyse99/TaskForge_PHP-Task-Manager/commits?q=ADR-006" style="color: #2563eb; text-decoration: none; font-weight: 600;">feat: Implement core TaskForge application with web UI and tests</a></td>
    </tr>
  </tbody>
</table>
