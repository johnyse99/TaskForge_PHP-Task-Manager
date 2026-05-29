\# TaskForge – PHP Task Manager



\## 📌 Overview

TaskForge is a lightweight \*\*Task Manager\*\* built with PHP.  

It is designed as a simple yet structured project to demonstrate clean architecture principles and provide a foundation for experimenting with modular development.



\---



\## ⚙️ Features

\- \*\*Create tasks\*\* with description and status.  

\- \*\*List tasks\*\* in a clean interface.  

\- \*\*Mark tasks completed\*\* or delete them.  

\- \*\*Store tasks\*\* in SQLite (default) or JSON file.  

\- \*\*Responsive UI\*\* using Bootstrap.  



\---



\## 🛠️ Tech Stack

\- \*\*Language:\*\* PHP 8.x  

\- \*\*Database:\*\* SQLite (via PDO) or JSON fallback  

\- \*\*UI:\*\* HTML5 + Bootstrap  

\- \*\*Testing:\*\* PHPUnit  



\---



\## 🚀 Installation

1\. Clone the repository:

&#x20;  ```bash

&#x20;  git clone https://github.com/johnyse99/taskforge.git

&#x20;  cd taskforge

&#x20;  ```

2\. Start PHP’s built-in server:

&#x20;  ```bash

&#x20;  php -S localhost:8000

&#x20;  ```

3\. Open in browser:  

&#x20;  ```

&#x20;  http://localhost:8000

&#x20;  ```



\---



\## 📂 Project Structure

```

/src

&#x20; /Domain

&#x20;   Task.php

&#x20;   TaskStatus.php

&#x20; /Application

&#x20;   TaskService.php

&#x20; /Infrastructure

&#x20;   TaskRepositorySQLite.php

&#x20;   TaskRepositoryJSON.php

&#x20; /Interface

&#x20;   TaskController.php

&#x20;   views/

index.php





