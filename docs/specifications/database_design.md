# Database Design: TaskForge

This document details the persistence architectures supported by the TaskForge system. TaskForge is designed with a dual-database capability, supporting both a primary **SQLite Relational Database** and a **JSON Flat-File Database** fallback.

---

## 1. Persistence Overview

The persistence strategy is defined by the `TaskRepositoryInterface` port. The system selects the storage driver at runtime based on the `.env` configuration file's `DB_DRIVER` value.

Supported values for `DB_DRIVER`:
- `sqlite` (Default) - Connects to a local SQLite database file using PHP PDO.
- `json` (Fallback) - Uses a structured JSON file to store data, with full concurrency locks.

---

## 2. SQLite Database Schema

The SQLite schema is designed for quick access, structured tables, and automatic row indexing. The database is hosted inside a single file defined by `SQLITE_DB_PATH` in `.env` (default: `data/database.sqlite`).

### 2.1 Table: `tasks`

The `tasks` table stores the core fields required for task management.

| Column | Data Type | Constraints | Description |
|---|---|---|---|
| `id` | `INTEGER` | `PRIMARY KEY AUTOINCREMENT` | Unique identifier for each task record. |
| `description` | `TEXT` | `NOT NULL` | Text description of the task. |
| `status` | `TEXT` | `NOT NULL` | State of the task. Standard values: `pending` or `completed`. |
| `created_at` | `TEXT` | `NOT NULL` | Creation timestamp formatted in ISO 8601 / ATOM string format. |

### 2.2 SQL Schema DDL
The database initializes the table automatically upon instantiating the SQLite repository adapter using the following code:

```sql
CREATE TABLE IF NOT EXISTS tasks (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    description TEXT NOT NULL,
    status TEXT NOT NULL,
    created_at TEXT NOT NULL
);
```

### 2.3 Key Repository SQL Queries

- **Create Task (Insert)**
  ```sql
  INSERT INTO tasks (description, status, created_at) VALUES (:description, :status, :created_at);
  ```

- **Update Task Status / Description (Update)**
  ```sql
  UPDATE tasks SET description = :description, status = :status WHERE id = :id;
  ```

- **Fetch All Tasks (Select All)**
  Tasks are loaded and sorted in descending order based on their creation time to display newest tasks first.
  ```sql
  SELECT * FROM tasks ORDER BY created_at DESC;
  ```

- **Find Task by ID (Select Single)**
  ```sql
  SELECT * FROM tasks WHERE id = :id;
  ```

- **Delete Task (Delete)**
  ```sql
  DELETE FROM tasks WHERE id = :id;
  ```

---

## 3. JSON flat-file Database Schema

For environments where SQLite extensions are unavailable, TaskForge provides a complete file-based database system using a local JSON file defined by `JSON_DB_PATH` in `.env` (default: `data/tasks.json`).

### 3.1 JSON Document Schema
The JSON database is represented as an array of JSON objects. Each object conforms to the following schema structure:

```json
[
  {
    "id": 1,
    "description": "Buy groceries",
    "status": "pending",
    "created_at": "2026-05-29T13:48:46-07:00"
  },
  {
    "id": 2,
    "description": "Send project report",
    "status": "completed",
    "created_at": "2026-05-29T11:20:00-07:00"
  }
]
```

### 3.2 Auto-Increment Key Emulation
Since JSON files do not have database engine auto-increments, ID generation is emulated programmatically when saving a new task:
1. Parse the existing tasks into a raw PHP array.
2. Scan the array to find the maximum `id` value.
3. Assign the new task an ID of `max_id + 1`.

### 3.3 Concurrency Control (File Locking)
To prevent race conditions, dirty writes, and file corruption when multiple users request the dashboard simultaneously, the JSON driver uses exclusive file locking:

1. **File Opening**: Open the JSON file stream using the `'c'` mode (open for reading and writing, creating the file if it doesn't exist).
2. **Acquire Lock**: Obtain an exclusive lock using `flock($fp, LOCK_EX)`. If the lock is held by another process, PHP blocks until it is released.
3. **Truncate File**: Erase the contents of the file pointer using `ftruncate($fp, 0)` so new data can overwrite it.
4. **Write Data**: Encode the PHP task array into a pretty-printed JSON string and write it.
5. **Flush Output**: Call `fflush($fp)` to force writing output to physical disk storage.
6. **Release Lock & Close**: Call `flock($fp, LOCK_UN)` followed by `fclose($fp)` to release the lock and close the file handle.
